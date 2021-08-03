<section class="profile mt-3">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>account login</h4>
                    </div>
                    <div class="card-body">
                        <form action="/user/login" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email address: <sup>*</sup></label>
                                <input 
                                    name="user[email]" 
                                    type="email" 
                                    class="form-control <?= isset($errors['email']) ? 'is-invalid' : 'is-valid' ?>" 
                                    id="userEmail"
                                    placeholder="Enter Email"
                                    value="<?= isset($source['email']) ? $source['email'] : '' ?>"
                                >
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['email'] ?>
                                    </div>
                                <?php else: ?>
                                    <div class="valid-feedback">Looks good!</div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password: <sup>*</sup></label>
                                <input 
                                    name="user[password]" 
                                    type="password" 
                                    class="form-control <?= isset($errors['password']) ? 'is-invalid' : 'is-valid' ?>" 
                                    id="userPassword"
                                    placeholder="Enter Password"
                                >
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php else: ?>
                                    <div class="valid-feedback">Looks good!</div>
                                <?php endif ?>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
