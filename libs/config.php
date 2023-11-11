<?php

/****
 * Librería donde incluimos aquellos datos (constantes, variables) 
 * que utilizaremos en todo el proyecto/ejercicio
 * @author Roger, Jonathan
 * 
 */

//Constante que define la ruta del proyecto
//COMENTAR LA QUE NO SE QUIERA UTILIZAR
//Ruta Jonathan 
// const ROOT = "http://localhost/app-dwes/";
//Ruta Roger
const ROOT = "http://localhost/app-dwes/";

$inactivityTime = 60 * 30;

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
$idiomas = ["Indiferente", "Castellano", "Ingles", "Valenciano",];

$categorias = ["Categoria 1", "Categoria 2", "Categoria 3",];

$disponibilidades = ["Mañanas", "Tardes", "Noches", "Completa", "Fines de semana"];

$pagos = ["Si", "No",];
