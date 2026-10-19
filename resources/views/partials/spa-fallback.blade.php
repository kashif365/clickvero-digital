@php $additionalContent = \App\Models\AdditionalContent::forCurrentPath(); @endphp
      <header>
         <a href="{{ route('home') }}">{{ $site['name'] }}</a>
         <nav>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('service') }}">Services</a>
            <a href="{{ route('project') }}">Portfolio</a>
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('contact') }}">Contact</a>
         </nav>
         <ul>
            @foreach ($site['services'] as $navService)
               <li><a href="{{ route('service.show', $navService['slug']) }}">{{ $navService['name'] }}</a></li>
            @endforeach
         </ul>
      </header>

      <main>
         @isset($service)
            <h1>{{ $service->headline ?: $service->name }}</h1>
            @if ($service->short_description)
               <p>{{ $service->short_description }}</p>
            @endif
            <div class="rich-content">{!! $service->description !!}</div>
            @foreach ($service->faqList() as $faq)
               <h3>{{ $faq['question'] }}</h3>
               <p>{{ $faq['answer'] }}</p>
            @endforeach
         @endisset

         @isset($blog)
            <h1>{{ $blog->title }}</h1>
            <div class="blog-content">{!! $blog->content !!}</div>
         @endisset

         @isset($services)
            <h1>Services</h1>
            @foreach ($services as $item)
               <h2><a href="{{ route('service.show', $item) }}">{{ $item->name }}</a></h2>
               <p>{{ $item->short_description }}</p>
            @endforeach
         @endisset

         @isset($blogs)
            <h1>Blog</h1>
            @foreach ($blogs as $item)
               <h2><a href="{{ route('blog-details', $item) }}">{{ $item->title }}</a></h2>
               <p>{{ $item->excerpt }}</p>
            @endforeach
         @endisset

         @if ($additionalContent)
            <section>
               @if ($additionalContent->title)
                  <h2>{{ $additionalContent->title }}</h2>
               @endif
               <div class="additional-content-scroll">
                  <div class="blog-content">{!! $additionalContent->content !!}</div>
               </div>
            </section>
         @endif
      </main>
