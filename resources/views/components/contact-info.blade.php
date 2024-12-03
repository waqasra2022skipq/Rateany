<div class="col">
    @if (auth()->check())
        @if($type == 'business' && auth()->user()->id == $entity->owner->id)
            <a href="{{ route('businesses.edit', $entity->id) }}" class="btn btn-outline-primary mb-2 w-100">Update</a>
        @endif
        @if($type == 'user' && auth()->user()->id == $entity->id)
            <a href="{{ route('profile.edit', $entity->id) }}" class="btn btn-outline-primary mb-2 w-100">Update</a>
        @endif
    @else
        @if($entity->contact_website)
            <a href="{{ $entity->contact_website }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary mb-2 w-100">
                <i class="fas fa-globe"></i> Website
            </a>
            <br>
        @endif
        
        @if($entity->contact_phone)
            <a href="tel:{{ $entity->contact_phone }}" class="btn btn-outline-success w-100">
                <i class="fas fa-phone"></i> Call
            </a>
        @endif
        @if($entity->contact_email)
            <a href="mailto:{{ $entity->contact_email }}" class="btn btn-outline-info mt-2 w-100">
                <i class="fas fa-envelope"></i> Email
            </a>
        @endif
    @endif
</div>
