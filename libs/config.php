<?php

/****
 * Librería donde incluimos aquellos datos (constantes, variables) 
 * que utilizaremos en todo el proyecto/ejercicio
 * @author Roger, Jonathan
 * 
 */

/**
 * Donde almacenaremos las imágenes que nos suben los usuarios
 */
$rutaImagenes = "images";

//Ruta donde almacenaremos los archivos
$rutaArchivos = "archivos";

/**
 * Array que guarda las extensiones válidas
 */
$extensionesValidas = ["jpeg", "gif", "jpg", "png", "webp"];

/**
 * Tamaño máximo del fichero subido. En bytes
 */
$maxFichero = 2000000;

//Formatos de fecha válidos
const FORMATOS_FECHA = ["dd-mm-aaaa", "aaaa-mm-dd"];

//Fecha máxima para la fecha de nacimiento
$fechaHoy = date("Y-m-d", time());


//Valores para la validacion del select
$idiomas = array(
    "castellano",
    "ingles",
    "valenciano",
);
