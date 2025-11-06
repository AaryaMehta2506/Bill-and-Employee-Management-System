const hamburger = document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");
const sidebar = document.querySelector("#sidebar");
// Toggle sidebar manually
hamburger.addEventListener("click", function () {
  sidebar.classList.toggle("expand");
  toggler.classList.toggle("bxs-chevrons-right");
  toggler.classList.toggle("bxs-chevrons-left");
});

// Automatically expand/collapse based on screen size
function handleSidebarResponsive() {
  if (window.innerWidth <= 768) {
    sidebar.classList.remove("expand"); // collapse for mobile
    toggler.classList.add("bxs-chevrons-right");
    toggler.classList.remove("bxs-chevrons-left");
  } else {
    sidebar.classList.add("expand"); // expand for desktop
    toggler.classList.remove("bxs-chevrons-right");
    toggler.classList.add("bxs-chevrons-left");
  }
}

// Run once on load and on resize
window.addEventListener("load", handleSidebarResponsive);
window.addEventListener("resize", handleSidebarResponsive);


new Chart(document.getElementById("bar-chart-grouped"), {
    type: 'bar',
    data: {
      labels: ["1900", "1950", "1999", "2050"],
      datasets: [
        {
          label: "Africa",
          backgroundColor: "#3e95cd",
          data: [133,221,783,2478]
        }, {
          label: "Europe",
          backgroundColor: "#8e5ea2",
          data: [408,547,675,734]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'Population growth (millions)'
      }
    }
});