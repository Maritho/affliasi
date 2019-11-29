<template>
  <div class="container">
    <template v-if="error.statusCode === 404">
      <section class="content">
        <div class="error-page">
          <h2 class="headline text-pln-default">404</h2>
          <div class="error-content">
            <h3>
              <i class="fa fa-exclamation-triangle text-pln-default"></i> Oops! Halaman tidak ditemukan.
            </h3>
            <p>
              Kami tidak dapat menemukan halaman yang Anda cari, Anda dapat kembali ke halaman
              <nuxt-link to="/">login</nuxt-link>
            </p>
          </div>
        </div>
      </section>
    </template>
    <template v-else>
      <section class="content">
        <div class="error-page">
          <h2 class="headline text-pln-default">500</h2>
          <div class="error-content">
            <h3>
              <i class="fas fa-exclamation-triangle text-pln-default"></i> Oops! Sepertinya ada yang salah.
            </h3>
            <p>
              Mohon maaf saat ini halaman sedang perbaikan, silahkan coba lagi nanti atau silahkan
              <nuxt-link to="/">masuk</nuxt-link>ke halaman login.
            </p>
          </div>
        </div>
      </section>
    </template>
  </div>
</template>

<script>
export default {
  props: ["error"],
  layout: "blank"
};
</script>