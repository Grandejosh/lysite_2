import * as dotenv from 'dotenv';
import { OpenAI } from "openai";

dotenv.config();

const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

//create new assistant mejor no crear a cada rato
// const assistant =  await openai.beta.assistants.create({
//     name: "Lyon",
//     instructions: "Eres un asistente de investigación y tesis para personas que desarrollan y necesitan ayuda con sus proyectos de investigación científica",
//     tools: [{
//                 type: "code_interpreter",
//             },
//     ],
//     model: "gpt-4-1106-preview"
// });


//usar uno existente usando su Id
const assistant = await openai.beta.assistants.retrieve(
    process.env.ASSISTANT_LYON
);

console.log("datos de asistente: ", assistant);


//creando Threads o HILOS de conversación
const thread = await openai.beta.threads.create();
console.log("Datos del Thread: ", thread);

//add messages usando el id del Thread
//se debe pasar mediante funcion el contenido de la pregunta del usuario
const message = await openai.beta.threads.messages.create(thread.id, {
    role: "user",
    content: "Este es el m ensaje del usuario que puedo preguntarte que tipo de asistente eres tu?",
});

//Run assistant 
const run = await openai.beta.threads.runs.create(thread.id, {
    assistant_id: assistant.id,
    instructions: "Responde al usuario se llama José Carlos",
});

console.log("Datos del run: ", run);