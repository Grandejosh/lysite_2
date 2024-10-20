import express from "express";

const app = express();

import mysql from 'mysql2';

import path from 'path';

app.use(express.json());

import * as dotenv from "dotenv";
import { OpenAI } from "openai";
import fs from 'fs';


dotenv.config();

const port = process.env.AI_ASSISTANT_PORT;
const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});
var file_id;
var filename;
var the_file_id;
let vectorStore_id=null;


// ------------------- Metodos GET o POST DEL API ----------------------------------------------------------

app.get("/create_thread", (req, res) => {
    createThread().then((thread) => {
        res.json(thread);
    });
});

// app.post("/create_run_", (req, res) => {
//     console.log("Datos del request: ", req.body.user_name);
//     let data = {
//         user_message: req.body.user_message,
//         user_name: req.body.user_name,
//         thread_id: req.body.thread_id,
//         assistant_id: req.body.assistant_id,
//     };

//     //console.log(data);
//     createRun(data).then((thread) => {
//         res.json(thread);
//     });
// });

app.post("/get_run_pending", (req, res) => {
    console.log("Datos del run pendiente: ", req.body.thread_id);
    let data = {
        thread_id: req.body.thread_id,
        run_id: req.body.run_id,
    };
    //console.log(data);
    getPendingRun(data).then((thread) => {
        res.json(thread);
    });
});
            //------------metodos para usar archivos

            app.post("/create_run", (req, res) => {
                console.log("Datos del request con file: ", req.body.user_name);
                console.log("------->>>>>>>_>>_>_>_>_>_>_>_>_>_>_>_>_>__> \n -------->>>>>>", req.body.file);

                // Verifica si se ha enviado un archivo
                if (req.body.file) {
                    console.log("llegó un archivo");
                    const directorioActual = "\\var\\www\\html\\" + process.env.PROJECT_PATH + "\\asistente_lyon\\";
                    const rutaDeseada = path.join(directorioActual, '..', 'storage', 'app', 'asistente_lyon');
                    console.log(req.body.file);

                    const file = "/var/www/html/" + process.env.PROJECT_PATH + "/asistente_lyon/asistente_lyon/"+req.body.file;
                    // // Obtiene la extensión del archivo
                    // const fileExtension = file.name.split('.').pop();

                    // // Obtiene el nombre del archivo
                    // const fileName = randomName(file.name.split('.').shift());

                    // const filePath = '/temp_files/asisstant/'+ fileName + '.' + fileExtension;
                    const filePath = file;
                  //  Mueve el archivo al directorio especificado

                    if(req.body.vector_id != null){
                        vectorStore_id = req.body.vector_id;
                    }
                        let data = {
                            user_message: req.body.user_message,
                            user_name: req.body.user_name,
                            thread_id: req.body.thread_id,
                            assistant_id: req.body.assistant_id,
                            file_path: filePath
                        };

                        createRun(data).then((thread) => {
                            res.json(thread);
                        });

                } else {
                    console.log("no llegó ningún archivo");
                    // No se envió ningún archivo
                    // let file_ids=null;
                    // if(req.body.file_ids != null){
                    //     file_ids = req.body.file_ids;
                    // }
                    let data = {
                        user_message: req.body.user_message,
                        user_name: req.body.user_name,
                        thread_id: req.body.thread_id,
                        assistant_id: req.body.assistant_id,
                        file_path: null
                    };

                    createRun(data).then((thread) => {
                        res.json(thread);
                    });
                }
            });





const createThread = async () => {
    //usar uno existente usando su Id
    const assistant = await openai.beta.assistants.retrieve(
        process.env.ASSISTANT_LYON
    );

    //creando Threads o HILOS de conversación
    const thread = await openai.beta.threads.create();
    console.log("35 Datos del Thread: ", thread);

    let data = {
        thread_id: thread.id,
        assistant_id: assistant.id,
    };

    return data;
};

const createRun = async (data) => {
    file_id = null;
    const archivo = data.file_path;
    filename = archivo;
    console.log(data);
    if(archivo != null){
        console.log("pasando archivo aqui--> hay archivo not null");
            // Upload a file with an "assistants" purpose
                const file = await openai.files.create({
                    file: fs.createReadStream(archivo),
                    purpose: "assistants",
                });
                the_file_id = file.id;
                console.log("EL ID DEL ARCHIVO ES: ", file.id);
                console.log("creando el vector store");

                let vectorStore = await openai.beta.vectorStores.create({
                    name: the_file_id,
                    file_ids: [the_file_id],
                    expires_after: {
                      anchor: "last_active_at",
                      days: 1
                    }
                  });
                  vectorStore_id = vectorStore.id;

                  console.log("aqui se creo el vectorStore.id ------------->>>>> "+vectorStore.id);

                const message = await openai.beta.threads.messages.create(
                data.thread_id, {
                                role: "user",
                                content: data.user_message,
                                attachments:[
                                {
                                    "file_id":the_file_id,
                                    "tools":[
                                        {
                                        "type":"file_search"
                                        }
                                    ]
                                }
                                ],

                });
                save_in_DB(the_file_id, filename);
                console.log("mensaje con fileid: ", message);

    }else{
        console.log("no subo archivo pero debo pasar el id del vector si existiera: ");
                const message = await openai.beta.threads.messages.create(
                data.thread_id, {
                                role: "user",
                                content: data.user_message,
                });
                console.log("mensaje donde paso el file_id que ya se subió antes: ", message);
    }


    //Run assistant [{ type: "file_search" }],
    var run;
    if(vectorStore_id!=null){
        run = await openai.beta.threads.runs.create(data.thread_id, {
            assistant_id: data.assistant_id,
            tool_resources: {
                file_search: {
                  vector_store_ids: [vectorStore_id]
                }
            }
         });
    }else{
        run = await openai.beta.threads.runs.create(data.thread_id, {
            assistant_id: data.assistant_id,
         });
    }
    console.log("aquí justo se creó el run con datos del asistente");
    await new Promise((resolve) => setTimeout(resolve, 500));
    const run_retrieve = await openai.beta.threads.runs.retrieve(
        data.thread_id, //este dato es el thread_id del hilo creado
        run.id //este es el run_id al correr el run
    );
    console.log("Datos del run: ", run);
    console.log("STATUS DEL RUN -> ", run_retrieve["status"]);
    let check_run = run_retrieve["status"];
    let steps = 0;
    while (check_run != "completed") {
        await new Promise((resolve) => setTimeout(resolve, 600));
        const check_run_retrieve = await openai.beta.threads.runs.retrieve(
            data.thread_id, //este dato es el thread_id del hilo creado
            run.id //este es el run_id al correr el run
        );
        console.log("STATUS DEL RUN -> ", check_run_retrieve["status"]);
        check_run = check_run_retrieve["status"];
        steps++;
        if(steps > 13){
            var resp = {};
            resp['run_id'] = check_run_retrieve['id'];
            resp['thread_id'] = check_run_retrieve['thread_id'];
            resp['status'] = "Pending";
            return resp;
            break;
        }
    }

    //obterner la respuesta de gpt

    let respuesta = [];

    const messages = await openai.beta.threads.messages.list(
        data.thread_id // ide el thread
    );

    messages.body.data.forEach((row) => {
        respuesta.push(row.content);
    });
    respuesta.push({vectorStore_id});
    respuesta.push({ file_id });
    return respuesta;
};

const getPendingRun = async (data) => {
    let check_run = null;
    let steps = 0;
    while (check_run != "completed") {
        if(check_run != "failed"){
            await new Promise((resolve) => setTimeout(resolve, 500));
            const get_run_retrieve = await openai.beta.threads.runs.retrieve(
                data.thread_id, //este dato es el thread_id del hilo creado
                data.run_id //este es el run_id al correr el run
            );
            console.log("STATUS DEL RUN -> ", get_run_retrieve["status"]);
            check_run = get_run_retrieve["status"];
            steps++;
            if(steps > 11){
                var resp = {};
                resp['run_id'] = get_run_retrieve['id'];
                resp['thread_id'] = get_run_retrieve['thread_id'];
                resp['status'] = "Pending";
                resp['file_id'] = file_id;
                return resp;
                break;
            }
        }else if(check_run == "failed"){
            return "hubo un problema por favor intenta de nuevo";
        }else{
            return false;
            break;
        }
    }

    let respuesta = [];

    const messages = await openai.beta.threads.messages.list(
        data.thread_id // id del thread
    );

    messages.body.data.forEach((row) => {
        respuesta.push(row.content);
    });
    return respuesta;

};

function save_in_DB(file_id, filename) {
    const connection = mysql.createConnection({
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASWORD,
        database: process.env.DB_DATABASE_NAME
      });

      const insertQuery = 'INSERT INTO assistant_gpt_files_ids (id, filename, deleted, created_at) VALUES (?, ?, ?, NOW())';
        const values = [file_id, filename, false];

        connection.query(insertQuery, values, (error, results) => {
        if (error) {
            console.error('Error al insertar los valores: ' + error.stack);
            return;
        }

        console.log('Valores insertados correctamente.');
        connection.end();

        });
  }

app.listen(port, () => {
    console.log(`El servidor está escuchando en el puerto ${port}`);
});
