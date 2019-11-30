let up = document.getElementsByClassName('affiliate-moladin');

generatorImage()

// te //
function generatorImage() {
  for(let i = 0; i < up.length; i++)
  {

    const affliate_id = up[i].dataset.affliateId;
    const width = up[i].dataset.width;
    const height = up[i].dataset.height;
    const style = up[i].dataset.style ? up[i].dataset.style : 'img-fluid';


    let img = new Image();
    img.src = 'https://res.cloudinary.com/devnas/image/upload/v1571939731/sneakershoot/sliders/banner-1.jpg';
    img.className = style
    img.onclick = function() {
      window.location.href = 'https://dev.sneakershoot.id/';
    };

    up[i].appendChild(img);
  }
}
