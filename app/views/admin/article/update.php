<section class="actions">
    <div class="container">
        <div class="row actions__btns">
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="posts.html" class="btn btn-info actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#arrow-circle-left-solid"></use>
                        </svg>
                        back to dashboard
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a href="posts.html" class="btn btn-success actions__btn">
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#check-circle-solid"></use>
                        </svg>
                        save changes
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid gap-2">
                    <a 
                        href="/article/delete/<?= $article->id ?>" 
                        class="btn btn-danger actions__btn"
                        onclick="return confirm('Are you sure?')"
                    >
                        <svg class="actions__icon">
                            <use xlink:href="/assets/admin/icons/sprite.svg#trash-alt-solid"></use>
                        </svg>
                        delete post
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.actions -->

<section class="detail">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h4>edit post</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="articleTitle" class="form-label">Title</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="articleTitle" 
                                    aria-describedby="emailHelp"
                                    value="<?= $article->title ?>"
                                >
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="postCat" class="form-label">Category</label>
                                <select id="postCat" class="form-select">
                                    <option value="">Web Development</option>
                                    <option value="" selected>Tech Gadgets</option>
                                    <option value="">Business</option>
                                    <option value="">Health & Wellness</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Default file input example</label>
                                <input class="form-control" type="file" id="formFile">
                            </div>
                            <div class="mb-3">
                                <label for="articleExcerpt" class="form-label">Excerpt</label>
                                <textarea 
                                    class="form-control" 
                                    id="articleExcerpt" 
                                    rows="3"
                                ><?= $article->excerpt ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="articlePost" class="form-label">Post</label>
                                <textarea 
                                    class="form-control" 
                                    id="articlePost" 
                                    rows="3"
                                ><?= $article->post ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>
<!-- /.detail -->
