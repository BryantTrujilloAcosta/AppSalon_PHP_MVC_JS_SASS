<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>
<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu Nombre"
        />
    </div>
    <div class="campo">
        <label for="email">Correo</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu Email"
        />
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Password"
        />
    </div>
        <input type="submit" class="boton" value="Crear Cuenta">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>