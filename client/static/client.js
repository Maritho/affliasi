let up = document.getElementsByClassName('affiliate-moladin');
let host = 'https://api.affliasi.devnas.com';

generatorImage()

// te //
async function generatorImage() {
  if (up.length == 0) {
    return false;
  }

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      let json = JSON.parse(xhr.responseText);

      for (let i = 0; i < up.length; i++) {

        const affliate_id = up[i].dataset.affliateId;
        const width = up[i].dataset.width;
        const height = up[i].dataset.height;
        const style = up[i].dataset.style ? up[i].dataset.style : 'img-fluid';

        let img = new Image();
        img.src = json.result.image;
        img.title = json.result.campaign_name;
        img.className = style
        img.onclick = function () {
          window.open(host + '/api/transaction/tracking/?affliate_id='+affliate_id+'&campaign_id='+json.result.id_campaign, '_blank');
        };

        setInterval(function () {
          if (up[i] != 'undefined') {
            up[i].appendChild(img);
          }
        }, 1000);
      }
    }
  }
  xhr.open('GET', host + '/api/campaign/ads');
  await xhr.send();
}
