<template>
    <div>
      <!-- Global site tag (gtag.js) - Google Analytics
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-180024160-1');
      </script> -->

        <PartialsHeader />
          <main>
                <slot></slot>
          </main>
        <PartialsFooter />
    </div>
</template> 