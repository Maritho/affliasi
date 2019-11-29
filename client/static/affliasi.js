let up = document.getElementById('affiliate-moladin');
const data = document.querySelector('#affiliate-moladin');

const affliate_id = data.dataset.affliateId;
const width = data.dataset.width;
const height = data.dataset.height;

console.log(affliate_id);

if (affliate_id) {

}

generatorImage()

function generatorImage() {

  let img = new Image();
  img.src = 'https://media.geeksforgeeks.org/wp-content/uploads/20190529122828/bs21.png';

  let link = new Location();
  link.href = 'https://moladin.com';
  link.assign(img)
  // img.onclick = function() {
  //   window.location.href = 'http://putyourlocationhere/';
  // };

  up.appendChild(link);
}
