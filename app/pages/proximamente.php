<?php
$titulo = etiqueta_de_ruta(current_route(), Auth::user()['rol']);
render('proximamente', ['title' => $titulo, 'titulo' => $titulo]);