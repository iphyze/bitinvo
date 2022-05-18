const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

const data = {
labels: labels,
datasets: [{
  label: 'Invoice Analytics',
  backgroundColor: 'rgb(29, 96, 188)',
  borderColor: 'rgb(29, 96, 188)',
  data: [0, 10, 5, 2, 20, 30, 45],
}]
};

const config = {
type: 'line',
data: data,
options: {}
};


const myChart = new Chart(
document.getElementById('myChart'),
    config
);