<?php

/****
 * Librería donde incluimos aquellos datos (constantes, variables) 
 * que utilizaremos en todo el proyecto/ejercicio
 * @author Roger, Jonathan
 * 
 */

const DB_HOSTNAME = "localhost";
const DB_NOMBRE = "evaluable_7w";
const DB_USUARIO = "root";
const DB_CLAVE = '';

/**
 * Constante que define la ruta del proyecto
 */
const APP_ROOT = "/app-dwes/";

//NO USAR
const RUTA_BASE = __DIR__ . "../../";

/**
 * Colores de tema de la página
 */
const TEMAS = ['Oscuro', 'Claro'];

/**
 * Tiempo de inactividad del usuario en segundos
 */
const INACTIVITY_TIME = 60 * 20;

/**
 * Donde almacenaremos las imágenes que nos suben los usuarios
 */
const RUTA_IMAGENES = "images";

/**
 * Ruta donde almacenaremos los archivos de texto
 */
const RUTA_ARCHIVOS  = "archivos";

/**
 * Array que guarda las extensiones válidas
 */
const EXTENSIONES_VALIDAS = ["jpeg", "gif", "jpg", "png", "webp"];

/**
 * Tamaño máximo del fichero subido. En bytes
 */
const MAX_FICHERO = 2000000;

/**
 * Formatos de fecha válidos
 */
const FORMATOS_FECHA = ["dd-mm-aaaa", "aaaa-mm-dd"];

/**
 * Fecha máxima para la fecha de nacimiento
 */
$fechaHoy = date("Y-m-d", time());

/**
 * Valores de idiomas disponibles para los usuarios
 */
$idiomas = ["Indiferente", "Castellano", "Ingles", "Valenciano",];

/**
 * Categorias disponibles en los servicios
 */
const TIPOS_IDS = [0 => "Servicio de intercambio", 1 => "Servicio de pago"];

/**
 * Disponibilidades horarias para los servicios
 */
$disponibilidades = ["Mañanas", "Tardes", "Noches", "Completa", "Fines de semana"];

/**
 * Valores para opción de pago en los servicios
 */
