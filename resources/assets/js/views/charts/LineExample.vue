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
            data: [ 40,20 ,100 , 60, 80, 123, 35 , 66, 133 ,11, 20,200 ]
          },
          {
            label: 'Income',
            backgroundColor: 'pink',
            data: [ 33,60 ,90 , 70, 20, 153, 135 , 116, 133 ,201, 120,200 ]
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
  watch: {
    data: function (data) {
      this._chart.destroy()
      this.renderChart({
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: data
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
      })
    }
    
  },
}
</script>
