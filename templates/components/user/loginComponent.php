<div class="box-login form-clasic">
  <div class="header_" style="height: 100px;">
    <div class="cont-lock"><i class="material-icons lock">lock</i></div>
    <div class="bottom-head"><h1 class="title">Login</h1></div>
  </div> 
   <form action="" method="post" onsubmit="return false" id="formLogin">
    <div class="group-inputMaterial">      
      <input class="inputMaterial" type="text" style="width:300px;" name="username" required>
      <label class="label-input">Username</label>
    </div>
	  <div class="group-inputMaterial">      
      <input class="inputMaterial" type="password" name="password" style="width:300px;" required>
      <label class="label-input">Password</label>
    </div>
    <button id="buttonlogintoregister" class="button-hover btn-third" type="submit" style="width:330px;" onclick="login()" name="enviar">Login</button>
  </form>
  <div class="footer_"><p class="text">Not a member?<span class="sign-up" onclick="getFormLogin('signup')"> Sign up now</span></p></div>
</div>

