<h1 class="nombre-pagina">Inicio de sesión</h1>
<p class="descripcion-pagina">Inicia sesión en tu cuenta</p>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Correo</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu Correo"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Contraseña"
        />
    </div>
        <input type="submit" class="boton" value="Iniciar Sesión">
</form>
<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu password?</a>

</div>