<section 
  class="relative h-screen bg-cover bg-center" 
  style="background-image: url('<?php echo get_field('hero')['background_image']; ?>');"
>
  <div class="absolute inset-0 bg-black/70"></div> <!-- overlay -->

  <div class="relative z-10 flex flex-col items-center justify-center h-full px-4 text-center text-white">
    
    <!-- Logo -->
    <div class="mb-6">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
        <span class="text-white">Fast Foot</span>
        <span class="text-neutral-300">Style</span>
      </h1>
    </div>

    <!-- Heading + subheading -->
    <div class="max-w-2xl">
      <h2 class="text-3xl md:text-4xl font-bold mb-4 leading-snug">
        <?php echo get_field('hero')['heading']; ?>
      </h2>
      <p class="text-lg md:text-xl text-gray-300 mb-8">
        <?php echo get_field('hero')['subtext']; ?>
      </p>
    </div>

    <!-- Search form -->
    <form action="/search" method="get" class="w-full max-w-xl flex items-center">
      <input 
        type="text" 
        name="s"
        class="flex-grow px-5 py-3 rounded-l-lg text-black text-sm md:text-base focus:outline-none"
        placeholder="<?php echo get_field('hero')['search_placeholder']; ?>"
      >
      <button 
        type="submit"
        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-r-lg transition-all duration-200"
      >
        <?php echo get_field('hero')['search_button_text']; ?>
      </button>
    </form>

  </div>
</section>
