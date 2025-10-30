  @props(['user','size'=>'w-12 h-12'])
  @if ($user->image)
       <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full object-cover">
   @else
       <img src="https://www.shutterstock.com/image-vector/smart-adult-businessman-avatar-icon-man-2610529405"
           alt="dummy avatar" class="{{ $size }} rounded-full object-cover">
   @endif
