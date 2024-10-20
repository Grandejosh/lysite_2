let autors;
let title;
let grade;
let editor;
let editorial;
let volumen;
let university;
let pais;
let institucion;
let issn;
let isbn;
let enlace;
let date;
let date_consulta;
let namepage;
let normativa;
let edicion;
let doi;
let repositorio;
let selectedRadioButton;
let numero;
let paginas;
let concatenado;
let siglas;
let libro;
let n_titulo;
let titulo;
let capitulo;
let capitulo_nombre;
let tipoDoc;
let modify_able = false;

function refresh_values() {

    normativa = document.getElementById("select-normativa").value;
    editor = document.getElementById("input-editorr").value;
    autors = document.getElementById("input-autor").value;
    tipoDoc = autors;
    title = document.getElementById("input-titulo").value;
    grade = document.getElementById("input-grado").value;
    editorial = document.getElementById("input-editorial").value;
    edicion = document.getElementById("input-edicion").value;
    volumen = document.getElementById("input-volumen").value;
    university = document.getElementById("input-universidad").value;
    pais = document.getElementById("input-pais").value;
    institucion = document.getElementById("input-institucion").value;
    issn = document.getElementById("input-issn").value;
    isbn = document.getElementById("input-isbn").value;
    enlace = document.getElementById("input-enlace").value;
    namepage = document.getElementById("input-namepage").value;
    date = document.getElementById("input-date").value;
    doi = document.getElementById("input-doi-a").value;
    repositorio = document.getElementById("input-repositorio").value;
    numero = document.getElementById("input-numero").value;
    paginas = document.getElementById("input-paginas").value;
    date_consulta = document.getElementById("input-date-consulta").value;
    siglas = document.getElementById("input-siglas").value;
    libro = document.getElementById("input-libro").value;
    n_titulo = document.getElementById("input-n-titulo").value;
    titulo = document.getElementById("input-titulo").value;
    capitulo = document.getElementById("input-capitulo").value;
    capitulo_nombre = document.getElementById("input-capitulo-nombre").value;

    date = new Date(date + 'T00:00:00');
    date.setMinutes(date.getTimezoneOffset());
    date_consulta = new Date(date_consulta + 'T00:00:00');
    date_consulta.setMinutes(date_consulta.getTimezoneOffset());
    if (!doi.startsWith("http://dx.doi.org/")) {
        doi = "http://dx.doi.org/" + doi;
    }

}

function manual_citation(event) {
    entidad_autor_swap(event);
    let cita_autores = "";
    refresh_values();
    // obtiene el elemento HTML del botón de opción seleccionado
    //let selectedRadioButton = document.querySelector('input[name="input-type"]:checked').value;

    // verificar si la cadena termina con ";"
    if (autors.endsWith(";") || autors.endsWith(".") || autors.endsWith(",")) {
        // si termina con ";", eliminar el último carácter
        autors = autors.slice(0, -1);
    }
    // separar el string en cada persona usando ";"
    let personas = autors.split(";");

    // matriz para almacenar los nombres y apellidos separados
    let nombresApellidos = [];

    // para cada persona, separar el nombre y los apellidos usando ","
    try {
        personas.forEach(persona => {
            let nombreApellido = persona.trim().split(",");
            let nombres = nombreApellido[0].trim().split(" ");
            let apellidos = nombreApellido[1].trim().split(" ");

            let primerNombre = nombres[0] ? nombres[0] : "";
            let segundoNombre = nombres[1] ? nombres.slice(1).join(" ") : "";
            let primerApellido = apellidos[0] ? apellidos[0] : "";
            let segundoApellido = apellidos[1] ? apellidos.slice(1).join(" ") : "";

            nombresApellidos.push({ primerNombre, segundoNombre, primerApellido, segundoApellido });
        });
    } catch (error) {
    }
    autors = nombresApellidos;
    let fecha = new Date(date);
    let fecha_consulta = new Date(date_consulta);
    // Obtener el día y el mes de la fecha, y utilizarlos para crear la nueva cadena
    let dia = fecha.getDate();
    let mes = fecha.toLocaleString('default', { month: 'long' });
    let anio = fecha.getFullYear();
    let dia_consulta = fecha_consulta.getDate();
    let mes_consulta = fecha_consulta.toLocaleString('default', { month: 'long' });
    let anio_consulta = fecha_consulta.getFullYear();



    if (selectedRadioButton == "article") {
        if (normativa == "apa") {

            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += autor.primerApellido[0].toUpperCase() + autor.primerApellido.slice(1) + "-" + autor.segundoApellido[0].toUpperCase() + autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += ", & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            let volnum;
            if (volumen.length < 1 && numero.length < 1) {
                volnum = "";
            } else {
                volnum = "<em>" + volumen.trim() + "</em>" + "(" + numero.trim() + "), ";
            }
            concatenado = cita_autores + "(" + anio + "). " + title.trim() + ". " + "<em>" + institucion.trim() + ",</em> " + volnum + paginas + ". " + doi;

        }

        if (normativa == "iso690") {
            // autors.forEach((autor, index) => {
            //     autor.primerApellido = autor.primerApellido.toUpperCase();
            //     cita_autores += autor.primerApellido + ", " + autor.primerNombre;
            //           if (index === autors.length - 1) {
            //         cita_autores += " ";
            //     } else {
            //         if (index === autors.length - 2){
            //             cita_autores += " y ";
            //         }else{
            //             cita_autores += ", ";
            //         }

            //     }
            // });
            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += autor.primerApellido.toUpperCase() + "-" + autor.segundoApellido.toUpperCase() + ", " + autor.primerNombre.charAt(0).toUpperCase() + autor.primerNombre.slice(1) + "";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += "; & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += "; ";
                    }

                }
            });

            if (issn.length < 1) {
                issn = " ";
            } else {
                issn = "ISSN: " + issn;
            }
            let volnum;
            if (volumen.length < 1 && numero.length < 1) {
                volnum = "";
            } else {
                volnum = volumen.trim() + "(" + numero.trim() + "): ";
            }
            concatenado = cita_autores + ". <em>" + title.trim() + "</em> - " + institucion.trim() + "-[en línea] " + mes + " " + anio + ", " + volnum + paginas.trim() + " [Fecha de consulta:" + dia_consulta + " de " + mes_consulta + " de " + anio_consulta + "]. Disponible en: " + doi + " " + issn;

        }


        if (normativa == "vancouver") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido;
                cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1)+ "-"+autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += ", ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            let volnum;
            if (volumen.length < 1 && numero.length < 1) {
                volnum = "";
            } else {
                volnum = volumen.trim() + "(" + numero.trim() + "): ";
            }
            concatenado = cita_autores + title.trim() + ". " + institucion + ". " + anio + "; " + volnum + paginas.trim() + ". " + doi;
        }

    }
    if (selectedRadioButton == "book") { //LIBROS VIRTUALES

        if (normativa == "apa") {

            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += ", & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            if (edicion < 2) {
                edicion = "";
            } else {
                edicion = "(" + edicion + "° edición).";
            }
            concatenado = cita_autores + "(" + anio + "). <em>" + title.trim() + ".</em> " + editorial.trim() + "." + enlace;

        }

        if (normativa == "iso690") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido.toUpperCase();
                cita_autores += autor.primerApellido.toUpperCase() + " " + autor.segundoApellido.toUpperCase() + ", " + autor.primerNombre.toUpperCase() + "";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += "; & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += "; ";
                    }

                }
            });
            if (edicion < 2) {
                edicion = " ";
            } else {
                edicion = edicion + "° edición. ";
            }
            if (isbn.length < 1) {
                isbn = " ";
            } else {
                isbn = "ISBN: " + isbn;
            }
            concatenado = cita_autores + ". <em>" + title.trim() + "</em> [en línea]. " + edicion.trim() + pais.trim() + ": " + editorial.trim() + ", " + anio + " [Fecha de consulta: " + dia_consulta + " de " + mes_consulta + " de " + anio_consulta + "]. Disponible en: " + enlace + isbn;

        }

        if (normativa == "vancouver") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido;
                cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1) + " " + autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += ", ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            if (edicion < 2) {
                edicion = "";
            } else {
                edicion = edicion + "° ed. ";
            }

            concatenado = cita_autores + title.trim() + "[Internet]. " + pais + ": " + editorial + "; " + anio + ". Disponible en: " + enlace;

        }

    }
    if (selectedRadioButton == "book-fisico") {
        if (normativa == "apa") {

            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += ", & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += ", ";
                    }

                }
            });

            if (edicion < 2) {
                edicion = "";
            } else {
                edicion = "(" + edicion + "° edición).";
            }
            concatenado = cita_autores + "(" + anio + "). <em>" + title.trim() + ".</em> " + edicion.trim() + " " + pais.trim() + ": " + editorial.trim() + ".";

        }

        if (normativa == "iso690") {
            // autors.forEach((autor, index) => {
            //     autor.primerApellido = autor.primerApellido.toUpperCase();
            //     cita_autores += autor.primerApellido + ", " + autor.primerNombre;
            //           if (index === autors.length - 1) {
            //         cita_autores += " ";
            //     } else {
            //         if (index === autors.length - 2){
            //             cita_autores += " y ";
            //         }else{
            //             cita_autores += ", ";
            //         }

            //     }
            // });

            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido.toUpperCase();
                cita_autores += autor.primerApellido.toUpperCase() + " " + autor.segundoApellido.toUpperCase() + ", " + autor.primerNombre.toUpperCase() + "";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += "; & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += "; ";
                    }

                }
            });
            if (edicion < 2) {
                edicion = " ";
            } else {
                edicion = edicion + "° edición. ";
            }
            if (isbn.length < 1) {
                isbn = " ";
            } else {
                isbn = "ISBN: " + isbn;
            }
            concatenado = cita_autores + ". <em>" + title.trim() + ".</em> " + edicion.trim() + pais.trim() + ": " + editorial.trim() + ", " + anio + ". " + isbn;

        }


        if (normativa == "vancouver") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido;
                cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1) + " " + autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += ", ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += ", ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            if (edicion < 2) {
                edicion = "";
            } else {
                edicion = edicion + "° ed. ";
            }

            concatenado = cita_autores  + title.trim() + ". " + edicion + pais + ": " + editorial + "; " + anio + ".";

        }
    }
    if (selectedRadioButton == "thesis") {

        if (normativa == "apa") {

            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        if(autors.length >= 3){
                            cita_autores += ", & ";
                        }else{
                        cita_autores += " & ";
                        }
                    }else{
                        cita_autores += ", ";
                    }

                }
            });

            concatenado = cita_autores + "(" + anio + "). <em>" + title.trim() + ".</em> " + "[" + grade + ", " + institucion + "]. " + repositorio + ". " + enlace;

        }

        if (normativa == "iso690") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido.toUpperCase();
                autor.segundoApellido = autor.segundoApellido.toUpperCase();
                cita_autores += autor.primerApellido + " " + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase()+autor.primerNombre.slice(1) + " " + autor.segundoNombre[0].toUpperCase()+autor.segundoNombre.slice(1);
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += " & ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });

            concatenado = cita_autores.trim() + ". <em>" + title.trim() + ".</em> Tesis [" + grade + "] " + pais.trim() + ": " + institucion.trim() + ", " + anio + ". Disponible en: " + enlace;

        }


        if (normativa == "vancouver") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido;
                cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1)+" "+autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                    if (index === autors.length - 1) {
                    cita_autores += ", ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += ", ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });

            concatenado = cita_autores + title.trim() + " [" + grade + "]. Sede: " + pais + ": " + repositorio + "; " + anio + ". " + enlace;

        }

    }

    if (selectedRadioButton == "document-gubernamental") {

        let emisor = "";
        if (normativa == "apa") {

            if (institucion.length < 1) { //si se escribió nombre de una persona
                autors.forEach((autor, index) => {
                    var espacio = " ";
                    if (!autor.segundoApellido) espacio = "";

                    cita_autores += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                    if (index === autors.length - 2) {
                        if(autors.length >= 3){
                            cita_autores += ", & ";
                        }else{
                        cita_autores += " & ";
                        }
                    } else {
                        cita_autores += " ";
                    }
                });

                nombresApellidos = [];
                if (siglas.split(",").length > 1) {
                    try {
                        personas = siglas.split(";");
                        personas.forEach(persona => {
                            let nombreApellido = persona.trim().split(",");
                            let nombres = nombreApellido[0].trim().split(" ");
                            let apellidos = nombreApellido[1].trim().split(" ");

                            let primerNombre = nombres[0] ? nombres[0] : "";
                            let segundoNombre = nombres[1] ? nombres.slice(1).join(" ") : "";
                            let primerApellido = apellidos[0] ? apellidos[0] : "";
                            let segundoApellido = apellidos[1] ? apellidos.slice(1).join(" ") : "";

                            nombresApellidos.push({ primerNombre, segundoNombre, primerApellido, segundoApellido });
                        });
                    } catch (error) {
                    }

                    nombresApellidos.forEach((autor, index) => {
                        espacio = " ";
                        if (!autor.segundoApellido) espacio = "";

                        emisor += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                        if (index === autors.length - 1) {
                            emisor += " ";
                        } else {
                            emisor += ", ";
                        }
                    });

                    concatenado = cita_autores + "(" + anio + "). <em>" + title.trim() + ".</em> " + pais + ": " + emisor + " " + enlace;
                } else {
                    concatenado = cita_autores + "(" + anio + "). <em>" + title.trim() + ".</em> " + pais + ": " + siglas + ". " + enlace;
                }

            } else {
                concatenado = institucion + "[" + siglas + "] " + "(" + anio + "). <em>" + title.trim() + ".</em> " + pais + ": " + siglas + ". " + enlace;
            }
        }


        if (normativa == "iso690") {

            if (institucion.length < 1) {  //si se escribió nombre de una persona
                autors.forEach((autor, index) => {
                    autor.primerApellido = autor.primerApellido.toUpperCase();
                    cita_autores += autor.primerApellido + ", " + autor.primerNombre;
                    if (index === autors.length - 1) {
                        cita_autores += " ";
                    } else {
                        cita_autores += ", ";
                    }
                });

                concatenado = cita_autores + ". <em>" + title.trim() + ".</em> " + pais[0].trim().toUpperCase() + pais.trim().slice(1) + ": " + siglas.trim() + ", " + anio + ". Disponible en: " + enlace;
            } else {
                institucion[0] = institucion[0].toUpperCase();
                concatenado = institucion + " [" + siglas.trim().toUpperCase() + "]. " + "<em>" + title.trim() + ".</em> " + pais[0].trim().toUpperCase() + pais.trim().slice(1) + ": " + siglas.trim().toUpperCase() + ", " + anio + ". Disponible en: " + enlace;
            }
        }


        if (normativa == "vancouver") {

            let emisor = "";

            if (institucion.length < 1) {  //si se escribió nombre de una persona
                autors.forEach((autor, index) => {
                    cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1)+" "+autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                    if (index === autors.length - 1) {
                        cita_autores += " ";
                    } else {
                        cita_autores += ", ";
                    }
                });
                nombresApellidos = [];
                if (siglas.split(",").length > 1) {
                    try {
                        personas = siglas.split(";");
                        personas.forEach(persona => {
                            let nombreApellido = persona.trim().split(",");
                            let nombres = nombreApellido[0].trim().split(" ");
                            let apellidos = nombreApellido[1].trim().split(" ");

                            let primerNombre = nombres[0] ? nombres[0] : "";
                            let segundoNombre = nombres[1] ? nombres.slice(1).join(" ") : "";
                            let primerApellido = apellidos[0] ? apellidos[0] : "";
                            let segundoApellido = apellidos[1] ? apellidos.slice(1).join(" ") : "";

                            nombresApellidos.push({ primerNombre, segundoNombre, primerApellido, segundoApellido });
                        });
                    } catch (error) {
                    }

                    nombresApellidos.forEach((autor, index) => {
                        espacio = " ";
                        if (!autor.segundoApellido) espacio = "";

                        emisor += autor.primerApellido + espacio + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase() + ".";
                        if (index === autors.length - 1) {
                            emisor += " ";
                        } else {
                            emisor += " ";
                        }
                    });
                    concatenado = cita_autores + title.trim() + " [Internet]. " + pais.trim() + ": " + emisor + "; " + anio + ". Disponible en: " + enlace.trim();
                } else {
                    concatenado = cita_autores + title.trim() + " [Internet]. " + pais.trim() + ": " + siglas.trim().toUpperCase() + "; " + anio + ". Disponible en: " + enlace.trim();
                }
            } else { //si se escribio nombre de institucion
                concatenado = institucion + " " + title.trim() + " [Internet]. " + pais.trim() + ": " + siglas.trim().toUpperCase() + "; " + anio + ". Disponible en: " + enlace.trim();
            }

        }



    }
    if (selectedRadioButton == "page") {
        /*
        Apellido mayúscula, Nombre minúscula. Título de la página web, año. Disponible en: link de la pagina
        */
        if (normativa == "apa") {
            date = `${dia} de ${mes} de ${anio}`;

            autors.forEach((autor, index) => {
                var espacio = " ";
                if (!autor.segundoApellido) espacio = "";

                cita_autores += primeraLetraMayus(autor.primerApellido) + espacio + primeraLetraMayus(autor.segundoApellido) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += " y ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            concatenado = cita_autores + "(" + date + "). <em>" + title.trim() + ".</em> " + namepage.trim() + ". " + enlace.trim();
        }




        if (normativa == "iso690") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido.toUpperCase();
                autor.segundoApellido = autor.segundoApellido.toUpperCase();
                cita_autores += autor.primerApellido + " " + autor.segundoApellido + ", " + autor.primerNombre[0].toUpperCase()+autor.primerNombre.slice(1) + " " + autor.segundoNombre[0].toUpperCase()+autor.segundoNombre.slice(1);
                      if (index === autors.length - 1) {
                    cita_autores += " ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += " y ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            concatenado = cita_autores.trim() + ". <em>" + title.trim() + ",</em> " + anio + ". Disponible en: " + enlace.trim();
        }



        if (normativa == "vancouver") {
            autors.forEach((autor, index) => {
                autor.primerApellido = autor.primerApellido;
                cita_autores += autor.primerApellido[0].toUpperCase()+autor.primerApellido.slice(1)+" "+autor.segundoApellido[0].toUpperCase()+autor.segundoApellido.slice(1) + ", " + autor.primerNombre[0].toUpperCase() + ".";
                    if (index === autors.length - 1) {
                    cita_autores += ", ";
                } else {
                    if (index === autors.length - 2){
                        cita_autores += ", ";
                    }else{
                        cita_autores += ", ";
                    }

                }
            });
            concatenado = cita_autores + title.trim() + " [Internet]. " + pais + ": " + editor + "; " + anio + ". Disponible en: " + enlace.trim();
        }

    }


    if (selectedRadioButton == "document-legal-codigo-general") {
        if (normativa == "apa") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = tipoDoc + " - " + institucion + "(" + anio + ", " + mes + " " + dia + "). <em>" + siglas.trim() + ".</em> " + enlace.trim();
        }

        if (normativa == "iso690") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = tipoDoc + " - " + institucion + ". " + siglas + ", " + pais + ", " + dia + " de " + mes + " de " + anio + ". Disponible en: " + enlace.trim();
        }

        if (normativa == "vancouver") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = tipoDoc + " - " + institucion + ". " + siglas + ", " + pais + ", " + dia + " de " + mes + " de " + anio + ". Disponible en: " + enlace.trim();
        }
    }


    if (selectedRadioButton == "document-legal-codigo-explicito") {

        if (normativa == "vancouver") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = tipoDoc + " - " + libro + " " + n_titulo + " - " + titulo + " - " + capitulo + " - " + capitulo_nombre + " (" + anio + ", " + mes + " " + dia + "). " + siglas.trim() + ". " + enlace.trim();

        } else {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = tipoDoc + " - " + libro + " " + n_titulo + " - " + titulo + " - " + capitulo + " - " + capitulo_nombre + " (" + anio + ", " + mes + " " + dia + "). <em>" + siglas.trim() + ".</em> " + enlace.trim();
        }

    }

    if (selectedRadioButton == "document-legal-expedido-sala-penal") {

        if (normativa == "vancouver") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = titulo.trim() + ", " + siglas.trim() + " (" + anio + "). " + enlace.trim();

        } else {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = titulo.trim() + ", " + siglas.trim() + " (" + anio + "). " + enlace.trim();
        }

    }


    if (selectedRadioButton == "document-legal-expedido-sala-corte-suprema") {

        if (normativa == "vancouver") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = "Casación N° " + titulo.trim() + ", " + pais.trim() + ", " + siglas.trim() + ", (" + anio + "). " + enlace.trim();

        } else {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = "Casación N° " + titulo.trim() + ", " + pais.trim() + ", " + siglas.trim() + ", (" + anio + "). " + enlace.trim();
        }

    }

    if (selectedRadioButton == "document-legal-reglamento-notarial") {

        if (normativa == "vancouver") {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = "R.N. N° " + titulo.trim() + " " + pais.trim() + ` (${dia} de ${mes} de ${anio}). ` + siglas.trim() + ". " + enlace.trim();

        } else {
            mes = mes.toLowerCase();

            date = `${dia} de ${mes} de ${anio}`;
            if (dia < 10) dia = "0" + dia;

            concatenado = "R.N. N° " + titulo.trim() + " " + pais.trim() + ` (${dia} de ${mes} de ${anio}). ` + siglas.trim() + ". " + enlace.trim();

        }

    }

    //concatenado = editor + ";" + cita_autores + ";" + title + ";" + grade + ";" + editorial + ";" + volumen + ";" + university + ";" + pais + ";" + institucion + ";" + issn + ";" + isbn + ";" + enlace;

    document.getElementById("ly-ck-dialog-references-result").innerHTML = '<div class="alert alert-primary" id="citation-id" role="alert">' + concatenado + '</div>';
}

function select_citation(tipoInput) {
    if (tipoInput != "changenormative") {
        selectedRadioButton = tipoInput;
    }

    switch (selectedRadioButton) {
        case "article":
            document.getElementById('tipo-referencia').innerHTML = "Artículo";
            break;
        case "page":
            document.getElementById('tipo-referencia').innerHTML = "Página Web";
            break;
        case "book":
            document.getElementById('tipo-referencia').innerHTML = "Libro Virtual";
            break;
        case "book-fisico":
            document.getElementById('tipo-referencia').innerHTML = "Libro en Físico";
            break;
        case "document-gubernamental":
            document.getElementById('tipo-referencia').innerHTML = "Documento Gubernamental";
            break;
        case "document-legal":
            document.getElementById('tipo-referencia').innerHTML = "Documento Legal";
            break;
        case "thesis":
            document.getElementById('tipo-referencia').innerHTML = "Tesis";
            break;
        case "document-legal-codigo-general":
            document.getElementById('tipo-referencia').innerHTML = "Código general";
            break;
        case "document-legal-codigo-explicito":
            document.getElementById('tipo-referencia').innerHTML = "Código explícito";
            break;
        case "document-legal-expedido-sala-penal":
            document.getElementById('tipo-referencia').innerHTML = "Documento Expedido por Salas penales";
            break;
        case "document-legal-expedido-sala-corte-suprema":
            document.getElementById('tipo-referencia').innerHTML = "Documento expedido de Sala Penal permanente de la Corte Suprema";
            break;
        case "document-legal-reglamento-notarial":
            document.getElementById('tipo-referencia').innerHTML = "Reglamento Notarial";
            break;

        default:
            break;
    }
    refresh_values();
    try {
        manual_citation();
    } catch (error) {

        console.log("Falta llenar formulario");
    }
    hide_all_inputs();
    show_selected_inputs();
}


function hide_all_inputs() {
    function hide_input(id) {
        let input = document.getElementById(id);// Obtener los inputs por su id

        let div = input.parentElement;// Obtener el div que contiene cada input

        div.style.display = 'none';// Ocultar el div utilizando la propiedad display
    }
    hide_input('input-autor');
    hide_input('input-doi-a');
    hide_input('input-titulo');
    hide_input('input-namepage');
    hide_input('input-date');               //fecha de publicacion
    hide_input('input-date-consulta');      //fecha de consulta
    hide_input('input-grado');
    hide_input('input-universidad');
    hide_input('input-pais');
    hide_input('input-institucion');
    hide_input('input-issn');
    hide_input('input-isbn');
    hide_input('input-volumen');
    hide_input('input-paginas');
    hide_input('input-editorr');
    hide_input('input-editorial');
    hide_input('input-enlace');
    hide_input('input-numero');
    hide_input('input-edicion');
    hide_input('input-siglas');
    hide_input('input-repositorio');
    hide_input('input-libro');
    hide_input('input-n-titulo');
    hide_input('input-capitulo');
    hide_input('input-capitulo-nombre');

    let label = document.querySelector("label[for='input-autor']");
    label.textContent = "Autor/es:";
    label = document.getElementById("input-autor");
    label.placeholder = "John Miguel, Gutierrez Sosa; Carmen María, Mendoza Villa";
    label = document.querySelector("label[for='input-pais']");
    label.textContent = "Pais o Ciudad:";
    label = document.querySelector("label[for='input-institucion']");
    label.textContent = "Institución, Entidad o Revista:";
    label = document.getElementById("input-institucion");
    label.placeholder = "Escriba aquí...";
    let input = document.getElementById("input-grado");
    input.placeholder = "Bachiller, Maestría, Doctorado";
}


function show_selected_inputs() {

    //NORMATIVA APA

    if (normativa == "apa") {
        //page
        if (selectedRadioButton == "page") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-namepage');
            show_input('input-date');
            show_input('input-enlace');
        }
        //article
        if (selectedRadioButton == "article") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-institucion'); //institucion, entidad o revista
            show_input('input-volumen');
            show_input('input-numero');
            show_input('input-paginas');
            show_input('input-date');           //fecha publicacion
            show_input('input-doi-a');
        }
        //libro virtual
        if (selectedRadioButton == "book") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-date-consulta');
            show_input('input-editorial');
            show_input('input-enlace');
        }
        //libro físico
        if (selectedRadioButton == "book-fisico") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-editorial');
            show_input('input-edicion');
            show_input('input-pais');
        }
        //documento gubernamental
        if (selectedRadioButton == "document-gubernamental") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-pais');
            show_input('input-institucion');
            let label = document.querySelector("label[for='input-institucion']");
            label.textContent = "ó Autor Entidad:";
            label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Autor Persona:";
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad:";
            show_input('input-siglas');         //Siglas de entidad
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');
            document.getElementById("input-siglas").placeholder = "Siglas de la entidad emisosa o nombres y apellidos del emisor ejem: María José, Perez Miñano";
        }
        //TESIS
        if (selectedRadioButton == "thesis") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-grado');
            show_input('input-institucion');
            show_input('input-repositorio');
            let label = document.querySelector("label[for='input-grado']");
            label.textContent = "Titulación en que especialidad o carrera:";
            let input = document.getElementById("input-grado");
            input.placeholder = "Tesis de Licenciatura, Tesis gagistral o Tesis doctoral";
            label = document.querySelector("label[for='input-institucion']");
            label.textContent = "Universidad:";
            show_input('input-enlace');

        }

        //Doc LEGAL Codigo general
        if (selectedRadioButton == "document-legal-codigo-general") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal";
            show_input('input-institucion');
            label = document.querySelector("label[for='input-institucion']");
            label.textContent = "Número del decreto documento:";
            document.getElementById('input-institucion').placeholder = "Ejem. Decreto Legislativo N° 343";
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');

        }

        //Doc legal explícito
        if (selectedRadioButton == "document-legal-codigo-explicito") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal Federal";
            label = document.querySelector("label[for='input-libro']");
            label.innerHTML = "N° de Libro:";
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-libro');
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Nombre del título:";
            document.getElementById('input-titulo').placeholder = "Escribe aquí...";
            show_input('input-n-titulo');
            show_input('input-capitulo');
            show_input('input-enlace');
            show_input('input-capitulo-nombre');
        }


        //Doc legal Expedido por pleno jurisdiccional de salas penales
        if (selectedRadioButton == "document-legal-expedido-sala-penal") {
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número del acuerdo plenario:";
            document.getElementById('input-titulo').placeholder = "Ejem. 3-2011/CJ-116";
            show_input('input-enlace');
        }


        //Doc legal Expedido por Sala Penal permanente de la corte suprema
        if (selectedRadioButton == "document-legal-expedido-sala-corte-suprema") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número y año de Casación:";
            document.getElementById('input-titulo').placeholder = "Ejem. 634-2015";
            show_input('input-enlace');
        }


        //Doc legal Reglamento Notarial
        if (selectedRadioButton == "document-legal-reglamento-notarial") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            document.getElementById("input-pais").placeholder = "Ejem. del Santa, de Lima, de Apurimac";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número de Reglamento Notarial:";
            document.getElementById('input-titulo').placeholder = "Ejem. 1527-2016";
            show_input('input-enlace');
        }


    }






    //NORMATIVA ISO690

    if (normativa == "iso690") {
        //page
        if (selectedRadioButton == "page") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-namepage');
            show_input('input-date');
            show_input('input-enlace');
        }
        //article
        if (selectedRadioButton == "article") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-institucion'); //institucion, entidad o revista
            show_input('input-volumen');
            show_input('input-numero');
            show_input('input-paginas');
            show_input('input-date');                    //fecha publicacion
            show_input('input-date-consulta');          //fecha consulta
            show_input('input-doi-a');
            show_input('input-issn');
        }
        //libro
        if (selectedRadioButton == "book") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-date-consulta');      //fecha consulta
            show_input('input-edicion');
            show_input('input-editorial');
            show_input('input-pais');
            show_input('input-isbn');
            show_input('input-enlace');
        }
        //libro físico
        if (selectedRadioButton == "book-fisico") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-edicion');
            show_input('input-pais');
            show_input('input-editorial');
            show_input('input-date');           //fecha publicacion
            show_input('input-isbn');
        }
        //documento gubernamental
        if (selectedRadioButton == "document-gubernamental") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-pais');
            show_input('input-institucion');
            let label = document.querySelector("label[for='input-institucion']");
            label.textContent = "ó Autor Entidad:";
            label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Autor Persona:";
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "País/Ciudad:";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Nombre de la Institución o Entidad:";
            show_input('input-siglas');         //Siglas de entidad
            show_input('input-siglas');         //Siglas de entidad
            show_input('input-date');           //fecha publicacion
            document.getElementById("input-siglas").placeholder = "Nombre de la Institución";
            show_input('input-enlace');
        }
        //TESIS
        if (selectedRadioButton == "thesis") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-institucion');
            show_input('input-grado');
            let label = document.querySelector("label[for='input-grado']");
            label.textContent = "Titulación en que especialidad o carrera:";
            let input = document.getElementById("input-grado");
            input.placeholder = "Tesis de Licenciatura, Tesis de Maestría o Doctorado";
            label = document.querySelector("label[for='input-institucion']");
            label.textContent = "Universidad:";
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "País:";
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');
        }

        //Doc LEGAL Codigo general
        if (selectedRadioButton == "document-legal-codigo-general") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal";
            show_input('input-institucion');
            label = document.querySelector("label[for='input-institucion']");
            label.textContent = "Número o código:";
            document.getElementById('input-institucion').placeholder = "Ejem. Decreto Legislativo N° 343";
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Poder Ejecutivo del Perú";
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o País:";

        }

        //Doc legal explícito
        if (selectedRadioButton == "document-legal-codigo-explicito") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal Federal";
            label = document.querySelector("label[for='input-libro']");
            label.innerHTML = "N° de Libro:";
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-libro');
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Nombre del título:";
            document.getElementById('input-titulo').placeholder = "Escribe aquí...";
            show_input('input-n-titulo');
            show_input('input-capitulo');
            show_input('input-enlace');
            show_input('input-capitulo-nombre');
        }


        //Doc legal Expedido por pleno jurisdiccional de salas penales
        if (selectedRadioButton == "document-legal-expedido-sala-penal") {
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número del acuerdo plenario:";
            document.getElementById('input-titulo').placeholder = "Ejem. 3-2011/CJ-116";
            show_input('input-enlace');
        }


        //Doc legal Expedido por Sala Penal permanente de la corte suprema
        if (selectedRadioButton == "document-legal-expedido-sala-corte-suprema") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número y año de Casación:";
            document.getElementById('input-titulo').placeholder = "Ejem. 634-2015";
            show_input('input-enlace');
        }


        //Doc legal Reglamento Notarial
        if (selectedRadioButton == "document-legal-reglamento-notarial") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            document.getElementById("input-pais").placeholder = "Ejem. del Santa, de Lima, de Apurimac";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número de Reglamento Notarial:";
            document.getElementById('input-titulo').placeholder = "Ejem. 1527-2016";
            show_input('input-enlace');
        }
    }






    //NORMATIVA VANCOUVER

    if (normativa == "vancouver") {
        //page
        if (selectedRadioButton == "page") {
            show_input('input-autor');
            show_input('input-pais');
            show_input('input-titulo');
            show_input('input-editorr');
            show_input('input-date');
            show_input('input-enlace');
        }
        //article
        if (selectedRadioButton == "article") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-institucion'); //institucion, entidad o revista
            show_input('input-volumen');
            show_input('input-numero');
            show_input('input-paginas');
            show_input('input-date');                    //fecha publicacion
            show_input('input-doi-a');
        }
        //libro virtual
        if (selectedRadioButton == "book") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-editorial');
            show_input('input-pais');
            show_input('input-enlace');
        }
        //libro físico
        if (selectedRadioButton == "book-fisico") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-pais');
            show_input('input-edicion');
            show_input('input-editorial');
            show_input('input-date');           //fecha publicacion
        }
        //documento gubernamental
        if (selectedRadioButton == "document-gubernamental") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-pais');
            let label = document.querySelector("label[for='input-institucion']");
            label.textContent = "ó Autor Entidad:";
            label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Autor Persona:";
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad:";
            show_input('input-institucion');
            show_input('input-siglas');         //Siglas de entidad
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');
        }
        //Tesis
        if (selectedRadioButton == "thesis") {
            show_input('input-autor');
            show_input('input-titulo');
            show_input('input-date');           //fecha publicacion
            show_input('input-grado');
            let label = document.querySelector("input[id='input-grado']");
            label.placeholder = "Tesis de pregrado ó Tesis de posgrado:";
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Sede:";
            show_input('input-repositorio');
            show_input('input-enlace');
        }

        //Doc LEGAL Codigo general
        if (selectedRadioButton == "document-legal-codigo-general") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal";
            show_input('input-institucion');
            label = document.querySelector("label[for='input-institucion']");
            label.textContent = "Número o código:";
            document.getElementById('input-institucion').placeholder = "Ejem. Decreto Legislativo N° 343";
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Poder Ejecutivo del Perú";
            show_input('input-date');           //fecha publicacion
            show_input('input-enlace');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o País:";

        }

        //Doc legal explícito
        if (selectedRadioButton == "document-legal-codigo-explicito") {
            show_input('input-autor');
            let label = document.querySelector("label[for='input-autor']");
            label.innerHTML = "Tipo de Documento:";
            document.getElementById('input-autor').placeholder = "Ejem. Código Penal Federal";
            label = document.querySelector("label[for='input-libro']");
            label.innerHTML = "N° de Libro:";
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-libro');
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Nombre del título:";
            document.getElementById('input-titulo').placeholder = "Escribe aquí...";
            show_input('input-n-titulo');
            show_input('input-capitulo');
            show_input('input-enlace');
            show_input('input-capitulo-nombre');
        }


        //Doc legal Expedido por pleno jurisdiccional de salas penales
        if (selectedRadioButton == "document-legal-expedido-sala-penal") {
            show_input('input-date');
            show_input('input-siglas');
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora:";
            document.getElementById('input-siglas').placeholder = "Escribe aquí...";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número del acuerdo plenario:";
            document.getElementById('input-titulo').placeholder = "Ejem. 3-2011/CJ-116";
            show_input('input-enlace');
        }


        //Doc legal Expedido por Sala Penal permanente de la corte suprema
        if (selectedRadioButton == "document-legal-expedido-sala-corte-suprema") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número y año de Casación:";
            document.getElementById('input-titulo').placeholder = "Ejem. 634-2015";
            show_input('input-enlace');
        }


        //Doc legal Reglamento Notarial
        if (selectedRadioButton == "document-legal-reglamento-notarial") {
            show_input('input-date');
            show_input('input-siglas');
            show_input('input-pais');
            label = document.querySelector("label[for='input-pais']");
            label.textContent = "Ciudad o Distrito:";
            document.getElementById("input-pais").placeholder = "Ejem. del Santa, de Lima, de Apurimac";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Entidad Emisora/Lugar de expedición:";
            document.getElementById('input-siglas').placeholder = "Ejem. Sala Penal Transitoria";
            show_input('input-titulo');
            label = document.querySelector("label[for='input-titulo']");
            label.textContent = "Número de Reglamento Notarial:";
            document.getElementById('input-titulo').placeholder = "Ejem. 1527-2016";
            show_input('input-enlace');
        }
    }

}


function show_input(id) {
    const input = document.getElementById(id);
    const div = input.parentElement;
    div.style.display = 'block';
}

function entidad_autor_swap(event) {

    if (selectedRadioButton == "document-gubernamental") {
        let id = event.target.id;
        if (id == "input-autor") {
            document.querySelector('input#input-institucion').value = "";
            document.querySelector('input#input-institucion').placeholder = "Solo llene o Autor o Entidad";
            if (normativa == "iso690") {
                document.getElementById('input-siglas').placeholder = "Nombre de la institución o entidad"
                label = document.querySelector("label[for='input-siglas']");
                label.textContent = "Nombre de la Institución:";
            }

        }
        if (id == "input-institucion") {
            document.querySelector('textarea#input-autor').value = "";
            document.querySelector('textarea#input-autor').placeholder = "Solo llene o Autor o Entidad";
            label = document.querySelector("label[for='input-siglas']");
            label.textContent = "Siglas de la institución:";
            if (normativa == "iso690") {
                document.getElementById('input-siglas').placeholder = "Sigla de la institución o entidad"
                label = document.querySelector("label[for='input-siglas']");
                label.textContent = "Sigla de la Institución:";
            }
        }
    }

}

function copyCitation() {
    for (let index = 0; index < 4; index++) { // no sé por qué, pero si no lo ejecuto mas de una vez a veces no copia el texto.

        // Seleccionar el contenido del <div>
        const div = document.getElementById("citation-id");
        div.className = "";
        const range = document.createRange();
        range.selectNode(div);
        window.getSelection().addRange(range);

        // Copiar el contenido seleccionado
        document.execCommand("copy");

        // Desmarcar la selección
        window.getSelection().removeAllRanges();
        div.className = "alert alert-primary";

    }

}

function hideBuscar() {
    // Seleccionar el botón
    let btnBuscar = document.getElementById("ckgetBtnReference");

    // Agregar un evento al botón para alternar su visibilidad

    if (btnBuscar.style.display === "none") {
        // Si el botón está oculto, se muestra
        btnBuscar.style.display = "block";
        document.getElementById("input-doi-buscar-id").style.display = "block";
        let btnCitaManual = document.getElementById("cita-manual-id");
        btnCitaManual.className = "ly-ck-dialog-button btn-info mr-5";
    } else {
        // Si el botón está visible, se oculta
        btnBuscar.style.display = "none";
        document.getElementById("input-doi-buscar-id").style.display = "none";
        let btnCitaManual = document.getElementById("cita-manual-id");
        btnCitaManual.className = "ly-ck-dialog-button btn-secondary mr-5";
    }
}

function modifyCitation() {
    try {
        if (modify_able) {
            // Obtener el elemento div con el id "citation-id"
            var citationDiv = document.getElementById("citation-id");

            // Agregar el atributo contenteditable="true"
            citationDiv.setAttribute("contenteditable", "false");

            // Reemplazar la clase original por "alert alert-danger"
            citationDiv.className = "alert alert-primary";
            modify_able = false;
            let btnModify = document.getElementById("modify-citation-id");
            btnModify.className = "ly-ck-dialog-button btn-info mr-2";

        } else {
            // Obtener el elemento div con el id "citation-id"
            var citationDiv = document.getElementById("citation-id");

            // Agregar el atributo contenteditable="true"
            citationDiv.setAttribute("contenteditable", "true");

            // Reemplazar la clase original por "alert alert-danger"
            citationDiv.className = "alert alert-secondary";
            citationDiv.focus();
            modify_able = true;
            let btnModify = document.getElementById("modify-citation-id");
            btnModify.className = "ly-ck-dialog-button btn-secondary mr-2";
        }
    } catch (error) {

    }

}

function primeraLetraMayus(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
