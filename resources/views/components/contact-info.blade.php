<div class="d-flex flex-column flex-md-row gap-4">
    <div>
        <strong>Email:</strong> {{ $business->contact_email ?? 'Not provided' }}
    </div>
    <div>
        <strong>Phone:</strong>
        @if($business->contact_phone)
            <a href="tel:{{ $business->contact_phone }}" class="user-link">{{ $business->contact_phone }}</a>
        @else
            Not provided
        @endif
    </div>
    <div>
        <strong>Website:</strong>
        @if($business->contact_website)
            <a href="{{ $business->contact_website }}" target="_blank" rel="noopener noreferrer" class="user-link">{{ $business->contact_website }}</a>
        @else
            Not provided
        @endif
    </div>
</div>
