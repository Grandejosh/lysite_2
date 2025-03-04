from dotenv import load_dotenv
import os
from flask import Flask, request, jsonify
from openai import OpenAI
from werkzeug.utils import secure_filename
import threading
import time

# Configuración inicial
load_dotenv()
API_KEY = os.getenv("API_KEY_IA")  # Reemplaza con tu clave de API de OpenAI
ASSISTANT_ID = os.getenv('ASSISTANT_ID_IA')  # Reemplaza con el ID de tu asistente
PORT = 5000  # Puerto de conexión para la API
UPLOAD_FOLDER = "uploads"  # Carpeta para almacenar archivos subidos
ALLOWED_EXTENSIONS = {"txt", "pdf", "docx", "doc", "xls", "xlsx"}  # Extensiones de archivo permitidas

# Inicializa el cliente de OpenAI
client = OpenAI(api_key=API_KEY)

# Inicializa la aplicación Flask
app = Flask(__name__)
app.config["UPLOAD_FOLDER"] = UPLOAD_FOLDER

# Diccionario para almacenar el historial de conversaciones por usuario
user_conversations = {}

# Función para verificar extensiones de archivo permitidas
def allowed_file(filename):
    return "." in filename and filename.rsplit(".", 1)[1].lower() in ALLOWED_EXTENSIONS

# Función para manejar la lógica del asistente en un hilo separado
def handle_assistant_ai(user_id, user_content, file_name):
    # Buscar el archivo si se proporciona un nombre de archivo
    file_id = None
    file_path = None

    if file_name is not None and file_name != "":
        # Ruta base donde se buscará el archivo
        base_path = "/var/www/html/" + os.getenv("PROJECT_PATH") + "/asistente_lyon/"
        file_path = os.path.join(base_path, file_name)
        print(file_path)
        # Verificar si el archivo existe y tiene una extensión permitida
        if os.path.exists(file_path) and allowed_file(file_name):
            print("archivo encontrado")
            # Subir el archivo a OpenAI
            with open(file_path, "rb") as f:
                file_response = client.files.create(
                    file=f,
                    purpose="assistants"
                )
            file_id = file_response.id
        else:
            return jsonify({"error": "File not found or invalid file type"}), 400

    # Crear o recuperar un Thread para el usuario
    if user_id not in user_conversations:
        thread = client.beta.threads.create()
        user_conversations[user_id] = {"thread_id": thread.id}
        thread_id = thread.id
    else:
        thread_id = user_conversations[user_id]["thread_id"]

    # Adjuntar el archivo al mensaje usando el campo `attachments`
    attachments = []
    if file_id:
        attachments.append({
            "file_id": file_id,
            "tools": [{"type": "file_search"}]  # Especificar la herramienta
        })

    # Agregar el mensaje del usuario al Thread
    client.beta.threads.messages.create(
        thread_id=thread_id,
        role="user",
        content=user_content,
        attachments=attachments if attachments else None  # Adjuntar archivos si existen
    )

    # Ejecutar el asistente en el Thread
    run = client.beta.threads.runs.create(
        thread_id=thread_id,
        assistant_id=ASSISTANT_ID
    )

    # Esperar a que el asistente termine de procesar
    while run.status != "completed":
        time.sleep(1)  # Esperar 1 segundo antes de verificar nuevamente
        run = client.beta.threads.runs.retrieve(
            thread_id=thread_id,
            run_id=run.id
        )

    # Obtener los mensajes del Thread
    messages = client.beta.threads.messages.list(
        thread_id=thread_id
    )

    # Obtener la respuesta del asistente
    assistant_response = messages.data[0].content[0].text.value

    # Eliminar el archivo si se subió
    if file_path and os.path.exists(file_path):
        os.remove(file_path)

    # Devolver la respuesta del asistente
    return jsonify({"response": assistant_response})

# Ruta para manejar las conversaciones con el asistente
@app.route('/assistant_ai', methods=['POST'])
def assistant_ai():
    # Obtener los datos del POST
    user_id = request.form.get('user_id')
    user_content = request.form.get('message')
    file_name = request.form.get('archivo')  # Nombre del archivo como string

    if not user_id or not user_content:
        return jsonify({"error": "user_id and message are required"}), 400

    # Verificar si se debe olvidar la conversación
    if file_name == "forget":
        if user_id in user_conversations:
            del user_conversations[user_id]  # Borrar la conversación del usuario
            return jsonify({"response": "Conversación olvidada correctamente"}), 200
        else:
            return jsonify({"error": "No hay conversación para olvidar"}), 404

    # Manejar la solicitud en un hilo separado
    thread = threading.Thread(target=handle_assistant_ai, args=(user_id, user_content, file_name))
    thread.start()

    # Responder inmediatamente mientras se procesa la solicitud
    #return jsonify({"status": "processing"}), 202

# Iniciar la aplicación
if __name__ == '__main__':
    if not os.path.exists(UPLOAD_FOLDER):
        os.makedirs(UPLOAD_FOLDER)
    app.run(host="127.0.0.1", port=PORT, debug=True, threaded=True)
