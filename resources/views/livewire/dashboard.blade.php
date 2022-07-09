<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg h-96 w-96">
                    <div class="shadow-lg rounded-lg overflow-hidden">
                    <canvas class="p-1" id="chartPie"></canvas>
                </div>
            </div>
        </div>
    </div>

        <!-- Required chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart pie -->
<script>
const dataPie = {
    labels: ["Magacin {{ 200 }}", "Instalirani", "Zamenski", "Neispravni"],
    datasets: [
    {
        label: "Terminali",
        data: [{{ $too }}, 50, 100, 150],
        backgroundColor: [
        "rgb(255, 99, 132)",
        "rgb(225, 206, 86)",
        "rgb(153, 102, 255)",
        "rgb(120, 143, 241)",
        ],
        borderColor: "#333",
        borderWidth: 2,
        hoverOffset: 4,
    },
    ],
};

const configPie = {
    type: "pie",
    data: dataPie,
    options: {
        title:{
            display: true,
            text: "Grafik terminala",
        }
    }
};

var chartBar = new Chart(document.getElementById("chartPie"), configPie);
</script>


</div>
