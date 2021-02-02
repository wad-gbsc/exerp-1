<script>
import { Line } from 'vue-chartjs'
import { CustomTooltips } from 'coreui/coreui-plugin-chartjs-custom-tooltips'

export default {
  props: ['data'],
  components: {
    CustomTooltips
  },
  extends: Line,
  mounted () {
    this.renderChart(
      {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [
          {
            label: 'Sales',
            backgroundColor: 'lightblue',
            data: [this.january,this.january,this.january ]
          },
          {
            label: 'Income',
            backgroundColor: 'pink',
            data: [],
          }
        ]
        
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
          enabled: false,
          custom: CustomTooltips,
          intersect: true,
          mode: 'index',
          position: 'nearest',
          callbacks: {
            labelColor: function (tooltipItem, chart) {
              return { backgroundColor: chart.data.datasets[tooltipItem.datasetIndex].backgroundColor }
            }
          }
        }
      }
    ) 
  },
  created() {
     this.$http
        .get("api/january", {
            headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
            }
        })
        .then(response => {
            
            this.january = response.data.january;
        })
        .catch(error => {
            console.log(error);
        });
      },
  }

</script>
