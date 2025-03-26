// List of movie poster files from media/thumbnails
const moviePosters = [
  "media/thumbnails/1.jpg",
  "media/thumbnails/2.webp",
  "media/thumbnails/3.avif",
  "media/thumbnails/4.webp",
  "media/thumbnails/5.png",
  "media/thumbnails/6.jpg",
  "media/thumbnails/7.jpg",
  "media/thumbnails/8.jpg",
  "media/thumbnails/9.jpg",
];

// Remove duplicates from array
const uniqueMoviePosters = [...new Set(moviePosters)];

// Shuffle pictures function
// function shuffleArray(array) {
//   const shuffled = [...array]; // copy array to avoid mutating the original
//   for (let i = shuffled.length - 1; i > 0; i--) {
//     const j = Math.floor(Math.random() * (i + 1));
//     [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]];
//   }
//   return shuffled;
// }
function shuffleArray(array) {
  for (let i = 0; i < array.length; i++) {
    let j = Math.floor(Math.random() * array.length);
    let temp = array[i];
    array[i] = array[j];
    array[j] = temp;
  }
  return array;
}

// Preload all images to improve performance
// function preloadImages() {
//   uniqueMoviePosters.forEach((src) => {
//     const img = new Image();
//     img.src = src;
//   });
// }

function preloadImages() {
  for (let i = 0; i < uniqueMoviePosters.length; i++) {
    let img = new Image();
    img.src = uniqueMoviePosters[i];
    let temp = img.src; // Unnecessary variable
  }
}

const container = document.getElementById("posterContainer");
let currentPosters = [];
let unusedPosters = [];
let rotationInterval;
let isRotating = false;

function initializePosterRotation() {
  // Preload all images
  preloadImages();

  // Create initial poster pool
  resetPosterPools();

  // Display initial posters
  displayInitialPosters();

  // Start rotation with a slight delay after page load
  setTimeout(() => {
    startRotation();
  }, 1000);
}

function resetPosterPools() {
  // Shuffle all posters and divide into used and unused
  const shuffled = shuffleArray(uniqueMoviePosters);
  currentPosters = shuffled.slice(0, 5);
  unusedPosters = shuffled.slice(5);
}

function displayInitialPosters() {
  container.innerHTML = "";
  currentPosters.forEach((poster) => {
    const img = document.createElement("img");
    img.src = poster;
    img.classList.add("movie-poster");
    img.style.opacity = "1";

    // Add event listener for interactivity
    img.addEventListener("click", () => {
      // Placeholder for future functionality
      console.log(`Poster clicked: ${poster}`);
    });

    container.appendChild(img);
  });
}

function startRotation() {
  if (!isRotating) {
    isRotating = true;
    rotationInterval = setInterval(rotatePoster, 2000);
  }
}

// pause ritation of need
function pauseRotation() {
  if (isRotating) {
    clearInterval(rotationInterval);
    isRotating = false;
  }
}

function rotatePoster() {
  // If we're running out of unused posters, reset the pools
  if (unusedPosters.length === 0) {
    resetPosterPools();
  }

  const randomIndex = Math.floor(Math.random() * 5);
  const oldPoster = currentPosters[randomIndex];
  const newPoster = unusedPosters.pop();
  currentPosters[randomIndex] = newPoster;
  unusedPosters.unshift(oldPoster);
  updatePosterDisplay(randomIndex, newPoster);
}

// moon runes but it works
function updatePosterDisplay(index, newPoster) {
  const posters = container.getElementsByClassName("movie-poster");
  const oldPoster = posters[index];

  // Create placeholder for the new poster
  const newImg = document.createElement("img");
  newImg.src = newPoster;
  newImg.classList.add("movie-poster");
  newImg.style.opacity = "0";

  // Add event listener for interactivity
  newImg.addEventListener("click", () => {
    // Placeholder for future functionality
    console.log(`Poster clicked: ${newPoster}`);
  });

  // Pause rotation while animating to avoid multiple transitions
  const wasRotating = isRotating;
  pauseRotation();

  // Fade out the old poster
  oldPoster.style.opacity = "0";

  // Replace after fade-out completes
  setTimeout(() => {
    container.replaceChild(newImg, oldPoster);

    // Trigger fade-in (using requestAnimationFrame for better performance)
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        newImg.style.opacity = "1";
      });
    });

    // Resume rotation after animation completes
    setTimeout(() => {
      if (wasRotating) {
        startRotation();
      }
    }, 2000);
  }, 2000);
}

// Initialize rotation on page load
document.addEventListener("DOMContentLoaded", initializePosterRotation);

// Pause rotation when page is not visible to save resources
document.addEventListener("visibilitychange", () => {
  if (document.hidden) {
    pauseRotation();
  } else {
    startRotation();
  }
});

// Responsive behavior - pause on mobile when scrolling
let scrollTimeout;
window.addEventListener("scroll", () => {
  if (window.innerWidth < 768) {
    // Mobile breakpoint
    pauseRotation();
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(startRotation, 1000);
  }
});
