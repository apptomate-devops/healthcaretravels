<div class="social-buttons-wrapper">
    @if (IS_GOOGLE_SOCIAL_ENABLED)
        <a class="social-button btn-google" href="/social/redirect/google/{{$type}}">
            <div class="social-icon-wrapper">
                <img class="social-icon icon-google" src="/svg/google.svg" alt="google">
            </div>
            <span class="social-title">Sign in with Google</span>
        </a>
    @endif
    @if (IS_FACEBOOK_SOCIAL_ENABLED)
        <a class="social-button btn-facebook mt-15" href="/social/redirect/facebook/{{$type}}">
            <div class="social-icon-wrapper">
                <img class="social-icon icon-facebook" src="/svg/facebook.svg" alt="facebook">
            </div>
            <span class="social-title">Sign in with Facebook</span>
        </a>
    @endif
    @if (IS_GOOGLE_SOCIAL_ENABLED || IS_FACEBOOK_SOCIAL_ENABLED)
        <div class="text-line-highlight"><span class="or-highlight">or</span></div>
    @endif
</div>
