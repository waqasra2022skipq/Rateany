<div class="col-md-2">
    <div class="d-flex flex-column gap-2">
        
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="shareButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-share-alt"></i> Share
            </button>
            <ul class="dropdown-menu" aria-labelledby="shareButton">
                <li><a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                <li><a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode('Check out ' . $entity->name . ' on our platform!') }}" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li><a class="dropdown-item" href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($entity->name) }}" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><button class="dropdown-item copy-link-btn" onclick="copyToClipboard('{{ url()->current() }}')"><i class="fas fa-link"></i> Copy Link</button></li>
            </ul>
        </div>
        @include('components.contact-info', ['entity' => $entity])
    </div>
</div>