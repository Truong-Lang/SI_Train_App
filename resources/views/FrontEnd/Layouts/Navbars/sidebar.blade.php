<div class="sidebar">
  <div class="sidebar-wrapper">
    <ul class="nav">
      @if($sideBarMenu)
        @foreach($sideBarMenu as $item)
            @if(in_array($activePage,Lang::get('active_page_sidebar.'.$item->id)))
                @php $show = 'in'; $expand = 'true'; @endphp
            @else
                @php $show = ''; $expand = 'false'; @endphp
            @endif
          <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#{{$item->id}}" aria-expanded="{{$expand}}">
              <i class="fa {{$item->icon}}" aria-hidden="true"></i>
              <p>{{$item->name}} <i class="caret fa fa-angle-down"></i></p>
            </a>
            <div class="collapse {{ $show }}" id="{{$item->id}}">
              <ul class="nav">
                @foreach($item->childs as $child)
                  <?php
                      $url = '';
                      if (filter_var($child->url, FILTER_VALIDATE_URL)) {
                          $url = $child->url;
                      } elseif (!empty($child->url)) {
                          $url = route(\App\Common\Constant::FOLDER_URL_ADMIN . '.home_page') . '/' . $child->url;
                      }

                      $targetTab = '';
                      if ($child->attribute && strpos($child->attribute, \App\Common\Constant::ATTRIBUTE_NEW_TAB) !== false) {
                          $targetTab = '_blank';
                      }
                  ?>
                  <li class="nav-item">
                    <a class="nav-link"
                       href="{{ $url }}"
                       target="{{ $targetTab }}">
                      <span class="sidebar-normal">{{$child->name}} </span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          </li>
        @endforeach
      @endif
    </ul>
  </div>
</div>




