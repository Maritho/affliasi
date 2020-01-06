export default function ({ $axios }) {
  $axios.onRequest(config => {
    try{
      window.$nuxt.$root.$loading.start();
    } catch (e) {
      console.log('Opss');
    }
  });

  $axios.onResponse(config => {
    try {
      window.$nuxt.$root.$loading.finish();
    } catch (e) {
      console.log('Opss');
    }
  });
}
