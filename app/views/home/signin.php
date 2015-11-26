<div class="content">
  <h2 class="center">Formulario de Login</h2>
  <div class="wrap">
    <form class="signin center" action="/client/signin/">
      <ul>
        <li>
          <div class="group">
            <input type="text" name="username" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Username/Email:</label>
          </div>
        </li>
        <li>
          <div class="group">
            <input type="password" name="password" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Contraseña:</label>
          </div>
        </li>
        <li>
          <small><a href="<?=URL.'home/lost';?>">Olvidé la contraseña</a></small>
        </li>
        <li>
          <button class="btn lg" type="submit"><span>Login</span></button>
        </li>
      </ul>
    </form>
  </div>
</div>
<script>
  (function(doc){
    doc.querySelector('form').addEventListener('submit', function(e){
      e.preventDefault();
      console.dir(e.target.action);
      var inputs = Array.from(doc.querySelectorAll('form input'));
      var url = '';
      for (input of inputs) {
        url += input.value + '/';
      }
      window.location.href = e.target.action + url;
    }, false);
  })(document);
</script>
