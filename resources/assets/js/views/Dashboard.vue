<template>
  <div class="animated fadeIn">
    <notifications group="notification" />
    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-primary" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">13</h4>
            <p>All Report(s)</p>
          </div>
          <card-line1-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-success" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">232</h4>
            <p>Done Report(s)</p>
          </div>
          <card-bar-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-warning" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">45</h4>
            <p>Pending Report(s)</p>
          </div>
          <card-line3-chart-example class="chart-wrapper" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-danger" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">231</h4>
            <p>Account(s)</p>
          </div>
          <card-bar-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>

      <line-example></line-example>

      <!--/.col-->
    </div>
    <!--/.row-->
   
    <!--/.row-->
  </div>
</template>

<script>
import CardLine1ChartExample from "./dashboard/CardLine1ChartExample";
import CardLine2ChartExample from "./dashboard/CardLine2ChartExample";
import CardLine3ChartExample from "./dashboard/CardLine3ChartExample";
import CardBarChartExample from "./dashboard/CardBarChartExample";
import MainChartExample from "./dashboard/MainChartExample";
import SocialBoxChartExample from "./dashboard/SocialBoxChartExample";
import { Callout } from "../components/";

export default {
  name: "dashboard",
  components: {
    Callout,
    CardLine1ChartExample,
    CardLine2ChartExample,
    CardLine3ChartExample,
    CardBarChartExample,
    MainChartExample,
    SocialBoxChartExample
  },
  data: function() {
    return {
      chartData: {
        
      },
      forms: {
        dashboard: {
          fields: {
            from_datetime: new Date()
          }
        }
      }
    }
  },

  methods: {
    variant(value) {
      let $variant;
      if (value <= 25) {
        $variant = "info";
      } else if (value > 25 && value <= 50) {
        $variant = "success";
      } else if (value > 50 && value <= 75) {
        $variant = "warning";
      } else if (value > 75 && value <= 100) {
        $variant = "danger";
      }
      return $variant;
    },
 
  },
};
</script>
