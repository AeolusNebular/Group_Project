<!-- 🔐 Login modal -->
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

<script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LepUgsrAAAAAN7WFsXsuZmK-Ah789yy3Dtp5uij',
          'callback' : function(response) {
            document.getElementById('g-recaptcha-response').value = response;
        }
        });
      };
</script>

<div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="LoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Login</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- 📝 Login form -->
            <div class="modal-body">
                <form action="../Database_Php_Interactions/Login_Php_Code.php" method="POST">
                    <div class="mb-3">
                        <label for="Login_Email" class="form-label">Email address:</label>
                        <input type="email" class="form-control" id="Login_Email" name="Login_Email" placeholder="Example@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="Login_Password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="Login_Password" name="Login_Password" placeholder="Password" required>
                    </div>
                    
                    <!-- ⚠️ Error message area -->
                    <div class="alert alert-danger d-none" id="LoginErrorMessage"></div>
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    <div id="html_element"></div>

                    <div class="modal-footer">
                        <button action='submit' class="fancy-button">Login</button>
                    </div>
                </form>
            </div>
         
        </div>
    </div>
</div>