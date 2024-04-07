(function ($) {
  const isDark = localStorage.theme === "dark" ? true : false;
  const isRtl = localStorage.dir === "rtl" ? true : false;

  function generateData(baseval, count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      //var x =Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y =
        Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

      series.push([baseval, y, z]);
      baseval += 86400000;
      i++;
    }
    return series;
  }

  const colors = {
    primary: "#4669FA",
    secondary: "#A0AEC0",
    danger: "#F1595C",
    black: "#111112",
    warning: "#FA916B",
    info: "#0CE7FA",
    light: "#425466",
    success: "#50C793",
    "gray-f7": "#F7F8FC",
    dark: "#1E293B",
    "dark-gray": "#0F172A",
    gray: "#68768A",
    gray2: "#EEF1F9",
    "dark-light": "#CBD5E1",
  };

  const hexToRGB = (hex, alpha) => {
    var r = parseInt(hex.slice(1, 3), 16),
      g = parseInt(hex.slice(3, 5), 16),
      b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
      return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
      return "rgb(" + r + ", " + g + ", " + b + ")";
    }
  };

  // const areaChartHeight = document.getElementById("areaChart");
  // areaChartHeight.getAttribute("height") || 350

  const chartOptions = [
    {
      id: "areaChart",
      options: {
        chart: {
          height: 350,

          type: "area",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            data: [90, 70, 85, 60, 80, 70, 90, 75, 60, 80],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 4,
        },
        colors: ["#4669FA"],
        tooltip: {
          theme: "dark",
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },
        fill: {
          type: "gradient",
          colors: "#4669FA",
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.4,
            opacityTo: 0.5,
            stops: [50, 100, 0],
          },
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        xaxis: {
          categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0,
        },
      },
    },
    {
      id: "areaSpaline",
      options: {
        chart: {
          height: 350,
          type: "area",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            data: [31, 40, 28, 51, 42, 109, 100],
          },
          {
            data: [11, 32, 45, 32, 34, 52, 41],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        legend: {
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
          fontFamily: "Inter",
        },
        tooltip: {
          x: {
            format: "dd/MM/yy HH:mm",
          },
        },
      },
    },
    {
      id: "basicBarChart",
      options: {
        chart: {
          height: 350,
          type: "bar",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380],
          },
        ],
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },
        xaxis: {
          categories: [
            "South Korea",
            "Canada",
            "United Kingdom",
            "Netherlands",
            "Italy",
            "France",
            "Japan",
            "United States",
            "China",
            "Germany",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        colors: ["#4669FA"],
      },
    },
    {
      id: "columnChart",
      options: {
        chart: {
          height: 350,

          type: "bar",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "Net Profit",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
          },
          {
            name: "Revenue",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
          },
          {
            name: "Free Cash Flow",
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
          },
        ],
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "55%",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 10,
          colors: ["transparent"],
        },
        legend: {
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },

        xaxis: {
          categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        yaxis: {
          title: {
            text: "$ (thousands)",
          },
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },

        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },
        colors: ["#4669FA", "#0CE7FA", "#FA916B"],
      },
    },
    {
      id: "scatterChart",
      options: {
        chart: {
          height: 350,
          type: "scatter",
          zoom: {
            enabled: true,
            type: "xy",
          },
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "A",
            data: [
              [5.4, 170],
              [5.4, 100],
              [6.3, 170],
              [5.7, 140],
              [5.9, 130],
              [7.0, 150],
              [8.0, 120],
              [9.0, 170],
              [10.0, 190],
              [11.0, 220],
              [12.0, 170],
              [13.0, 230],
            ],
          },
          {
            name: "B",
            data: [
              [14.0, 220],
              [15.0, 280],
              [16.0, 230],
              [18.0, 320],
              [17.5, 280],
              [19.0, 250],
              [20.0, 350],
              [20.5, 320],
              [20.0, 320],
              [19.0, 280],
              [17.0, 280],
              [22.0, 300],
              [18.0, 120],
            ],
          },
          {
            name: "C",
            data: [
              [14.0, 290],
              [13.0, 190],
              [20.0, 220],
              [21.0, 350],
              [21.5, 290],
              [22.0, 220],
              [23.0, 140],
              [19.0, 400],
              [20.0, 200],
              [22.0, 90],
              [20.0, 120],
            ],
          },
        ],
        grid: {
          borderColor: isDark ? "#334155" : "#e2e8f0",
          xaxis: {
            lines: {
              show: true,
            },
          },
        },
        colors: ["#4669FA", "#FA916B", "#0CE7FA"],
        legend: {
          show: true,
          position: "bottom",
          horizontalAlign: "center",
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        xaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          tickAmount: 10,
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
            formatter(val) {
              return parseFloat(val).toFixed(1);
            },
          },
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
      },
    },
    {
      id: "bubbleChart",
      options: {
        chart: {
          height: 350,
          type: "bubble",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "Product1",
            data: generateData(new Date("11 Feb 2017 GMT").getTime(), 20, {
              min: 10,
              max: 60,
            }),
          },
          {
            name: "Product2",
            data: generateData(new Date("11 Feb 2017 GMT").getTime(), 20, {
              min: 10,
              max: 60,
            }),
          },
          {
            name: "Product3",
            data: generateData(new Date("11 Feb 2017 GMT").getTime(), 20, {
              min: 10,
              max: 60,
            }),
          },
          {
            name: "Product4",
            data: generateData(new Date("11 Feb 2017 GMT").getTime(), 20, {
              min: 10,
              max: 60,
            }),
          },
        ],
        dataLabels: {
          enabled: false,
        },

        fill: {
          type: "gradient",
        },
        legend: {
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },

        xaxis: {
          tickAmount: 12,
          type: "datetime",

          labels: {
            rotate: 0,
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },

        yaxis: {
          max: 70,
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        theme: {
          palette: "palette2",
        },
        colors: ["#4669FA", "#FA916B", "#50C793", "#0CE7FA"],
      },
    },
    {
      id: "candlestickChart",
      options: {
        chart: {
          height: 350,
          type: "candlestick",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            data: [
              {
                x: new Date(1538778600000),
                y: [6629.81, 6650.5, 6623.04, 6633.33],
              },
              {
                x: new Date(1538780400000),
                y: [6632.01, 6643.59, 6620, 6630.11],
              },
              {
                x: new Date(1538782200000),
                y: [6630.71, 6648.95, 6623.34, 6635.65],
              },
              {
                x: new Date(1538784000000),
                y: [6635.65, 6651, 6629.67, 6638.24],
              },
              {
                x: new Date(1538785800000),
                y: [6638.24, 6640, 6620, 6624.47],
              },
              {
                x: new Date(1538787600000),
                y: [6624.53, 6636.03, 6621.68, 6624.31],
              },
              {
                x: new Date(1538789400000),
                y: [6624.61, 6632.2, 6617, 6626.02],
              },
              {
                x: new Date(1538791200000),
                y: [6627, 6627.62, 6584.22, 6603.02],
              },
              {
                x: new Date(1538793000000),
                y: [6605, 6608.03, 6598.95, 6604.01],
              },
              {
                x: new Date(1538794800000),
                y: [6604.5, 6614.4, 6602.26, 6608.02],
              },
              {
                x: new Date(1538796600000),
                y: [6608.02, 6610.68, 6601.99, 6608.91],
              },
              {
                x: new Date(1538798400000),
                y: [6608.91, 6618.99, 6608.01, 6612],
              },
              {
                x: new Date(1538800200000),
                y: [6612, 6615.13, 6605.09, 6612],
              },
              {
                x: new Date(1538802000000),
                y: [6612, 6624.12, 6608.43, 6622.95],
              },
              {
                x: new Date(1538803800000),
                y: [6623.91, 6623.91, 6615, 6615.67],
              },
              {
                x: new Date(1538805600000),
                y: [6618.69, 6618.74, 6610, 6610.4],
              },
              {
                x: new Date(1538807400000),
                y: [6611, 6622.78, 6610.4, 6614.9],
              },
              {
                x: new Date(1538809200000),
                y: [6614.9, 6626.2, 6613.33, 6623.45],
              },
              {
                x: new Date(1538811000000),
                y: [6623.48, 6627, 6618.38, 6620.35],
              },
              {
                x: new Date(1538812800000),
                y: [6619.43, 6620.35, 6610.05, 6615.53],
              },
              {
                x: new Date(1538814600000),
                y: [6615.53, 6617.93, 6610, 6615.19],
              },
              {
                x: new Date(1538816400000),
                y: [6615.19, 6621.6, 6608.2, 6620],
              },
              {
                x: new Date(1538818200000),
                y: [6619.54, 6625.17, 6614.15, 6620],
              },
              {
                x: new Date(1538820000000),
                y: [6620.33, 6634.15, 6617.24, 6624.61],
              },
              {
                x: new Date(1538821800000),
                y: [6625.95, 6626, 6611.66, 6617.58],
              },
              {
                x: new Date(1538823600000),
                y: [6619, 6625.97, 6595.27, 6598.86],
              },
              {
                x: new Date(1538825400000),
                y: [6598.86, 6598.88, 6570, 6587.16],
              },
              {
                x: new Date(1538827200000),
                y: [6588.86, 6600, 6580, 6593.4],
              },
              {
                x: new Date(1538829000000),
                y: [6593.99, 6598.89, 6585, 6587.81],
              },
              {
                x: new Date(1538830800000),
                y: [6587.81, 6592.73, 6567.14, 6578],
              },
              {
                x: new Date(1538832600000),
                y: [6578.35, 6581.72, 6567.39, 6579],
              },
              {
                x: new Date(1538834400000),
                y: [6579.38, 6580.92, 6566.77, 6575.96],
              },
              {
                x: new Date(1538836200000),
                y: [6575.96, 6589, 6571.77, 6588.92],
              },
              {
                x: new Date(1538838000000),
                y: [6588.92, 6594, 6577.55, 6589.22],
              },
              {
                x: new Date(1538839800000),
                y: [6589.3, 6598.89, 6589.1, 6596.08],
              },
              {
                x: new Date(1538841600000),
                y: [6597.5, 6600, 6588.39, 6596.25],
              },
              {
                x: new Date(1538843400000),
                y: [6598.03, 6600, 6588.73, 6595.97],
              },
              {
                x: new Date(1538845200000),
                y: [6595.97, 6602.01, 6588.17, 6602],
              },
              {
                x: new Date(1538847000000),
                y: [6602, 6607, 6596.51, 6599.95],
              },
              {
                x: new Date(1538848800000),
                y: [6600.63, 6601.21, 6590.39, 6591.02],
              },
              {
                x: new Date(1538850600000),
                y: [6591.02, 6603.08, 6591, 6591],
              },
              {
                x: new Date(1538852400000),
                y: [6591, 6601.32, 6585, 6592],
              },
              {
                x: new Date(1538854200000),
                y: [6593.13, 6596.01, 6590, 6593.34],
              },
              {
                x: new Date(1538856000000),
                y: [6593.34, 6604.76, 6582.63, 6593.86],
              },
              {
                x: new Date(1538857800000),
                y: [6593.86, 6604.28, 6586.57, 6600.01],
              },
              {
                x: new Date(1538859600000),
                y: [6601.81, 6603.21, 6592.78, 6596.25],
              },
              {
                x: new Date(1538861400000),
                y: [6596.25, 6604.2, 6590, 6602.99],
              },
              {
                x: new Date(1538863200000),
                y: [6602.99, 6606, 6584.99, 6587.81],
              },
              {
                x: new Date(1538865000000),
                y: [6587.81, 6595, 6583.27, 6591.96],
              },
              {
                x: new Date(1538866800000),
                y: [6591.97, 6596.07, 6585, 6588.39],
              },
              {
                x: new Date(1538868600000),
                y: [6587.6, 6598.21, 6587.6, 6594.27],
              },
              {
                x: new Date(1538870400000),
                y: [6596.44, 6601, 6590, 6596.55],
              },
              {
                x: new Date(1538872200000),
                y: [6598.91, 6605, 6596.61, 6600.02],
              },
              {
                x: new Date(1538874000000),
                y: [6600.55, 6605, 6589.14, 6593.01],
              },
              {
                x: new Date(1538875800000),
                y: [6593.15, 6605, 6592, 6603.06],
              },
              {
                x: new Date(1538877600000),
                y: [6603.07, 6604.5, 6599.09, 6603.89],
              },
              {
                x: new Date(1538879400000),
                y: [6604.44, 6604.44, 6600, 6603.5],
              },
              {
                x: new Date(1538881200000),
                y: [6603.5, 6603.99, 6597.5, 6603.86],
              },
              {
                x: new Date(1538883000000),
                y: [6603.85, 6605, 6600, 6604.07],
              },
              {
                x: new Date(1538884800000),
                y: [6604.98, 6606, 6604.07, 6606],
              },
            ],
          },
        ],
        plotOptions: {
          candlestick: {
            colors: {
              upward: "#4669FA",
              downward: "#F1595C",
            },
          },
        },

        xaxis: {
          type: "datetime",
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },

        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },
        yaxis: {
          tooltip: {
            enabled: true,
          },
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        colors: ["#000000"],
      },
    },
    {
      id: "steplineChart",
      options: {
        chart: {
          height: 350,
          type: "line",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            data: [34, 44, 54, 21, 12, 43, 33, 23, 66, 66, 58],
          },
        ],
        stroke: {
          curve: "stepline",
        },
        dataLabels: {
          enabled: false,
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },
        legend: {
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        xaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        markers: {
          hover: {
            sizeOffset: 4,
          },
        },
      },
    },
    {
      id: "stackedColumns",
      options: {
        chart: {
          height: 350,
          type: "bar",
          stacked: true,
          stackType: "100%",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "PRODUCT A",
            data: [44, 55, 41, 67, 22, 43, 21, 49],
          },
          {
            name: "PRODUCT B",
            data: [13, 23, 20, 8, 13, 27, 33, 12],
          },
          {
            name: "PRODUCT C",
            data: [11, 17, 15, 15, 21, 14, 15, 13],
          },
        ],
        plotOptions: {
          bar: {
            columnWidth: "25%",
          },
        },
        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: "bottom",
                offsetX: -10,
                offsetY: 0,
              },
            },
          },
        ],
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },
        legend: {
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        xaxis: {
          categories: [
            "2011 Q1",
            "2011 Q2",
            "2011 Q3",
            "2011 Q4",
            "2012 Q1",
            "2012 Q2",
            "2012 Q3",
            "2012 Q4",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        fill: {
          opacity: 1,
        },
        colors: ["#4669FA", "#0CE7FA", "#FA916B"],
      },
    },
    {
      id: "pieChart",
      options: {
        chart: {
          height: 450,
          type: "pie",
          toolbar: {
            show: false,
          },
        },
        labels: ["Team A", "Team B", "Team C", "Team D", "Team E"],
        dataLabels: {
          enabled: true,
        },
        series: [44, 55, 13, 43, 22],
        colors: ["#4669FA", "#F1595C", "#50C793", "#0CE7FA", "#FA916B"],
        legend: {
          position: "bottom",
          fontSize: "16px",
          fontFamily: "Inter",
          fontWeight: 400,
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
          markers: {
            width: 6,
            height: 6,
            offsetY: -1,
            offsetX: -5,
            radius: 12,
          },
          itemMargin: {
            horizontal: 10,
            vertical: 0,
          },
        },

        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    },
    {
      id: "donutChart",
      options: {
        chart: {
          height: 450,
          type: "donut",
          toolbar: {
            show: false,
          },
        },
        labels: ["success", "Return", "Cancel"],
        series: [44, 55, 41],
        dataLabels: {
          enabled: true,
        },

        colors: ["#50C793", "#F1595C", "#FBBF24"],
        legend: {
          position: "bottom",
          fontSize: "16px",
          fontFamily: "Inter",
          fontWeight: 400,
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        plotOptions: {
          pie: {
            donut: {
              size: "65%",
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: "26px",
                  fontWeight: "bold",
                  fontFamily: "Inter",
                  color: isDark ? "#CBD5E1" : "#475569",
                },
                value: {
                  show: true,
                  fontFamily: "Inter",
                  color: isDark ? "#CBD5E1" : "#475569",
                  formatter(val) {
                    // eslint-disable-next-line radix
                    return `${parseInt(val)}%`;
                  },
                },
                total: {
                  show: true,
                  fontSize: "1.5rem",
                  color: isDark ? "#CBD5E1" : "#475569",
                  label: "Total",
                  formatter() {
                    return "20%";
                  },
                },
              },
            },
          },
        },

        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    },
    {
      id: "mixedChart",
      options: {
        chart: {
          stacked: false,
          height: 350,
          type: "line",
          toolbar: {
            show: false,
          },
        },

        series: [
          {
            name: "Column",
            type: "column",
            data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30],
          },
          {
            name: "Area",
            type: "area",
            data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43],
          },
          {
            name: "Line",
            type: "line",
            data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39],
          },
        ],

        stroke: {
          width: [0, 2, 5],
          curve: "smooth",
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },

        fill: {
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: "light",
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100],
          },
        },
        labels: [
          "01/01/2003",
          "02/01/2003",
          "03/01/2003",
          "04/01/2003",
          "05/01/2003",
          "06/01/2003",
          "07/01/2003",
          "08/01/2003",
          "09/01/2003",
          "10/01/2003",
          "11/01/2003",
        ],
        markers: {
          size: 0,
        },
        xaxis: {
          type: "datetime",
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        yaxis: {
          min: 0,
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function (y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + " views";
              }
              return y;
            },
          },
        },
        legend: {
          labels: {
            useSeriesColors: true,
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          position: "back",
        },
        colors: ["#4669FA", "#50C793", "#0CE7FA"],
      },
    },
    {
      id: "radarChart",
      options: {
        chart: {
          height: 450,
          type: "radar",
          toolbar: {
            show: false,
          },
          dropShadow: {
            enabled: false,
            blur: 8,
            left: 1,
            top: 1,
            opacity: 0.2,
          },
        },
        series: [
          {
            name: "Option A",
            data: [41, 64, 81, 60, 42, 42, 33, 23],
          },
          {
            name: "Option B",
            data: [65, 46, 42, 25, 58, 63, 76, 43],
          },
        ],
        legend: {
          show: true,
          fontSize: "14px",
          fontFamily: "Inter",
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        yaxis: {
          show: false,
        },
        //colors: [chartColors.donut.series1, chartColors.donut.series3],
        xaxis: {
          categories: [
            "Battery",
            "Brand",
            "Camera",
            "Memory",
            "Storage",
            "Display",
            "OS",
            "Price",
          ],
        },
        fill: {
          opacity: [1, 0.8],
        },
        stroke: {
          show: false,
          width: 0,
        },
        markers: {
          size: 0,
        },
        grid: {
          show: false,
        },
      },
    },
    {
      id: "radialbars",
      options: {
        chart: {
          height: 450,
          type: "radialBar",
          toolbar: {
            show: false,
          },
        },
        series: [44, 55, 67, 83],
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: "22px",
                color: isDark ? "#CBD5E1" : "#475569",
              },
              value: {
                fontSize: "16px",
                color: isDark ? "#CBD5E1" : "#475569",
              },
              total: {
                show: true,
                label: "Total",
                color: isDark ? "#CBD5E1" : "#475569",
                formatter: function () {
                  return 249;
                },
              },
            },
            track: {
              background: "#E2E8F0",
              strokeWidth: "97%",
            },
          },
        },
        labels: ["A", "B", "C", "D"],
        colors: ["#4669FA", "#FA916B", "#50C793", "#0CE7FA"],
      },
    },
    {
      id: "spae-line1",
      options: {
        chart: {
          type: "area",
          height: 41,
          width: 121,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#00EBFF"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "spae-line2",
      options: {
        chart: {
          type: "area",
          height: 41,
          width: 121,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],

        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#FB8F65"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "spae-line3",
      options: {
        chart: {
          type: "area",
          height: 41,
          width: 121,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#5743BE"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "wline1",
      options: {
        chart: {
          type: "area",
          height: 48,
          width: 48,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#00EBFF"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "wline2",
      options: {
        chart: {
          type: "area",
          height: 48,
          width: 48,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#FB8F65"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "wline3",
      options: {
        chart: {
          type: "area",
          height: 48,
          width: 48,
          toolbar: {
            autoSelected: "pan",
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            data: [800, 600, 1000, 800, 600, 1000, 800, 900],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: ["#5743BE"],
        tooltip: {
          theme: "light",
        },
        grid: {
          show: false,
          padding: {
            left: 0,
            right: 0,
          },
        },
        yaxis: {
          show: false,
        },
        fill: {
          type: "solid",
          opacity: [0.1],
        },
        legend: {
          show: false,
        },
        xaxis: {
          low: 0,
          offsetX: 0,
          offsetY: 0,
          show: false,
          labels: {
            low: 0,
            offsetX: 0,
            show: false,
          },
          axisBorder: {
            low: 0,
            offsetX: 0,
            show: false,
          },
        },
      },
    },
    {
      id: "clmn_chart_1",

      options: {
        chart: {
          height: 48,
          width: 124,
          type: "bar",
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            name: "Revenue",
            data: [40, 70, 45, 100, 75, 40, 80, 90],
          },
        ],
        plotOptions: {
          bar: {
            columnWidth: "60px",
            barHeight: "100%",
          },
        },
        legend: {
          show: false,
        },

        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },

        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + "k";
            },
          },
        },
        yaxis: {
          show: false,
        },
        xaxis: {
          show: false,
          labels: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        colors: colors.info,
        grid: {
          show: false,
        },
      },
    },
    {
      id: "clmn_chart_2",

      options: {
        chart: {
          height: 48,
          width: 124,
          type: "bar",
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            name: "Revenue",
            data: [40, 70, 45, 100, 75, 40, 80, 90],
          },
        ],
        plotOptions: {
          bar: {
            columnWidth: "60px",
            barHeight: "100%",
          },
        },
        legend: {
          show: false,
        },

        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },

        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + "k";
            },
          },
        },
        yaxis: {
          show: false,
        },
        xaxis: {
          show: false,
          labels: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        colors: colors.success,
        grid: {
          show: false,
        },
      },
    },
    {
      id: "clmn_chart_3",

      options: {
        chart: {
          height: 48,
          width: 124,
          type: "bar",
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
          sparkline: {
            enabled: true,
          },
        },
        series: [
          {
            name: "Revenue",
            data: [40, 70, 45, 100, 75, 40, 80, 90],
          },
        ],
        plotOptions: {
          bar: {
            columnWidth: "60px",
            barHeight: "100%",
          },
        },
        legend: {
          show: false,
        },

        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },

        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + "k";
            },
          },
        },
        yaxis: {
          show: false,
        },
        xaxis: {
          show: false,
          labels: {
            show: false,
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
        colors: colors.warning,
        grid: {
          show: false,
        },
      },
    },
    {
      id: "revenue-barchart",
      options: {
        chart: {
          height: 400,
          width: "100%",
          type: "bar",
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "Net Profit",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
          },
          {
            name: "Revenue",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
          },
          {
            name: "Free Cash Flow",
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
          },
        ],
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "45%",
          },
        },
        legend: {
          show: true,
          position: "top",
          horizontalAlign: "right",
          fontSize: "12px",
          fontFamily: "Inter",
          offsetY: -30,
          markers: {
            width: 8,
            height: 8,
            offsetY: -1,
            offsetX: -5,
            radius: 12,
          },
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
          itemMargin: {
            horizontal: 18,
            vertical: 0,
          },
        },
        title: {
          text: "Revenue Report",
          align: "left",

          offsetX: isRtl ? "0%" : 0,
          offsetY: 13,
          floating: false,
          style: {
            fontSize: "20px",
            fontWeight: "500",
            fontFamily: "Inter",
            color: isDark ? "#fff" : "#0f172a",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },
        yaxis: {
          opposite: isRtl ? true : false,
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        xaxis: {
          categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },

        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },
        colors: ["#4669FA", "#0CE7FA", "#FA916B"],
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#E2E8F0",
          strokeDashArray: 10,
          position: "back",
        },
        responsive: [
          {
            breakpoint: 600,
            options: {
              legend: {
                position: "bottom",
                offsetY: 8,
                horizontalAlign: "center",
              },
              plotOptions: {
                bar: {
                  columnWidth: "80%",
                },
              },
            },
          },
        ],
      },
    },
    {
      id: "radial-bar",
      options: {
        chart: {
          type: "radialBar",
          height: 360,
          toolbar: {
            show: false,
          },
        },
        series: [44, 55, 67, 83],
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: "22px",
                color: isDark ? "#CBD5E1" : "#475569",
              },
              value: {
                fontSize: "16px",
                color: isDark ? "#CBD5E1" : "#475569",
              },
              total: {
                show: true,
                label: "Total",
                color: isDark ? "#CBD5E1" : "#475569",
                formatter: function () {
                  return 249;
                },
              },
            },
            track: {
              background: "#E2E8F0",
              strokeWidth: "97%",
            },
          },
        },
        labels: ["A", "B", "C", "D"],
        colors: ["#4669FA", "#FA916B", "#50C793", "#0CE7FA"],
      },
    },
    {
      id: "radar-home-chart",
      options: {
        chart: {
          height: 320,
          type: "radialBar",
          toolbar: {
            show: false,
          },
        },
        series: [67],
        plotOptions: {
          radialBar: {
            startAngle: -135,
            endAngle: 135,
            dataLabels: {
              name: {
                fontSize: "22px",
                color: isDark ? "#E2E8F0" : "#475569",
              },
              value: {
                fontSize: "16px",
                color: isDark ? "#E2E8F0" : "#475569",
              },
              total: {
                show: true,
                label: "Total",
                color: isDark ? "#E2E8F0" : "#475569",
                formatter: function () {
                  return 249;
                },
              },
            },
          },
        },
        fill: {
          type: "gradient",
          gradient: {
            shade: "dark",
            shadeIntensity: 0.15,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 65, 91],
          },
        },
        stroke: {
          dashArray: 4,
        },
        colors: ["#4669FA"],
      },
    },
    {
      id: "visitor-chart",
      options: {
        chart: {
          height: 350,
          type: "radar",
          toolbar: {
            show: false,
          },
          dropShadow: {
            enabled: false,
            blur: 8,
            left: 1,
            top: 1,
            opacity: 0.5,
          },
        },
        series: [
          {
            name: "Male",
            data: [41, 64, 81, 60, 42, 42, 33, 23],
          },
          {
            name: "Female",
            data: [65, 46, 42, 25, 58, 63, 76, 43],
          },
        ],
        legend: {
          show: true,
          fontSize: "14px",
          fontFamily: "Inter",
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        yaxis: {
          show: true,
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        colors: [colors.warning, colors.primary],
        xaxis: {
          categories: [
            "2019",
            "2020",
            "2021",
            "2017",
            "2018",
            "2015",
            "2014",
            "2013",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
            },
          },
        },
        fill: {
          opacity: [0.5, 0.5],
        },
        stroke: {
          width: 2,
        },
        markers: {
          size: 0,
        },
        grid: {
          show: false,
        },
      },
    },
    {
      id: "stack-bar-chart",
      options: {
        chart: {
          height: 410,
          type: "bar",
          stacked: true,
          toolbar: {
            show: false,
          },
        },
        series: [
          {
            name: "Sales qualified",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
          },
          {
            name: "Meeting",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
          },
          {
            name: "In negotiation",
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
          },
        ],
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: "rounded",
            columnWidth: "55%",
          },
        },
        legend: {
          show: true,
          position: "bottom",
          horizontalAlign: "center",
          fontSize: "12px",
          fontFamily: "Inter",
          offsetY: 0,
          markers: {
            width: 6,
            height: 6,
            offsetY: 0,
            offsetX: -5,
            radius: 12,
          },
          itemMargin: {
            horizontal: 18,
            vertical: 0,
          },
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },

        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ["transparent"],
        },

        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },

        xaxis: {
          categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
          ],
          labels: {
            offsetY: -3,
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },

        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands";
            },
          },
        },
        colors: [colors.primary, colors.info, colors.warning],
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#E2E8F0",
          strokeDashArray: 10,
          position: "back",
        },
      },
    },
    {
      id: "pie-chart-cal",

      options: {
        chart: {
          height: 335,
          type: "pie",
          toolbar: {
            show: false,
          },
        },
        labels: ["70% Sent", "18% Opend", "12% Rejected"],
        dataLabels: {
          enabled: true,
        },

        colors: [colors.success, colors.warning, "#A3A1FB"],
        series: [44, 55, 30],
        legend: {
          position: "bottom",
          fontSize: "12px",
          fontFamily: "Inter",
          fontWeight: 400,
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
          markers: {
            width: 6,
            height: 6,
            offsetY: -1,
            offsetX: -5,
            radius: 12,
          },
          itemMargin: {
            horizontal: 10,
            vertical: 0,
          },
        },

        responsive: [
          {
            breakpoint: 480,
            options: {
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    },
    {
      id: "history-chart",
      options: {
        chart: {
          height: 360,
          type: "area",
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
        },
        series: [
          {
            name: "Earnings",
            data: [31, 40, 28, 51, 42, 109, 100],
          },
          {
            name: "Expenses",
            data: [11, 32, 45, 32, 34, 52, 41],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "straight",
          width: 2,
        },
        colors: [colors.primary, colors.warning],
        tooltip: {
          theme: "dark",
        },
        legend: {
          offsetY: 4,
          show: true,
          fontSize: "12px",
          fontFamily: "Inter",
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
          markers: {
            width: 6,
            height: 6,
            offsetY: 0,
            offsetX: -5,
            radius: 12,
          },
          itemMargin: {
            horizontal: 18,
            vertical: 0,
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },
        fill: {
          type: "gradient",
          gradient: {
            shadeIntensity: 0.3,
            opacityFrom: 0.4,
            opacityTo: 0.5,
            stops: [0, 30, 0],
          },
        },
        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
          ],
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
      },
    },
    {
      id: "account-receivable-chart",
      options: {
        chart: {
          height: 300,
          type: "line",
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
        },
        series: [
          {
            data: [31, 40, 28, 51, 42, 109, 100],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: [colors.warning],
        tooltip: {
          theme: "dark",
        },
        legend: {
          offsetY: 6,
          show: true,
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        markers: {
          size: 4,
          colors: colors.warning,
          strokeColors: colors.warning,
          strokeWidth: 2,
          shape: "circle",
          radius: 2,
          hover: {
            sizeOffset: 1,
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },

        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
      },
    },
    {
      id: "payable-chart",
      options: {
        chart: {
          type: "line",
          height: 300,
          toolbar: {
            show: false,
          },
          offsetX: 0,
          offsetY: 0,
          zoom: {
            enabled: false,
          },
        },
        series: [
          {
            data: [31, 40, 28, 51, 42, 109, 100],
          },
        ],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: "smooth",
          width: 2,
        },
        colors: [colors.primary],
        tooltip: {
          theme: "dark",
        },
        legend: {
          offsetY: 6,
          show: true,
          labels: {
            colors: isDark ? "#CBD5E1" : "#475569",
          },
        },
        markers: {
          size: 4,
          colors: colors.primary,
          strokeColors: colors.primary,
          strokeWidth: 2,
          shape: "circle",
          radius: 2,
          hover: {
            sizeOffset: 1,
          },
        },
        grid: {
          show: true,
          borderColor: isDark ? "#334155" : "#e2e8f0",
          strokeDashArray: 10,
          position: "back",
        },

        yaxis: {
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2018-09-19T00:00:00.000Z",
            "2018-09-19T01:30:00.000Z",
            "2018-09-19T02:30:00.000Z",
            "2018-09-19T03:30:00.000Z",
            "2018-09-19T04:30:00.000Z",
            "2018-09-19T05:30:00.000Z",
            "2018-09-19T06:30:00.000Z",
          ],
          labels: {
            style: {
              colors: isDark ? "#CBD5E1" : "#475569",
              fontFamily: "Inter",
            },
          },
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
      },
    },
  ];

  const chartJsOptions = [
    {
      id: "chart1",
      type: "bar",
      data: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],
        datasets: [
          {
            label: " data one",
            data: [35, 59, 80, 81, 56, 55, 40],
            fill: false,
            backgroundColor: hexToRGB(colors.primary, 0.6),
            borderColor: colors.primary,

            borderWidth: 2,
            borderRadius: "15",
            borderSkipped: "bottom",
            barThickness: 25,
          },
          {
            label: " data two",
            data: [24, 42, 40, 19, 86, 27, 90],
            fill: false,
            backgroundColor: hexToRGB(colors.success, 0.8),
            borderColor: colors.success,
            borderWidth: 2,
            borderRadius: "15",
            borderSkipped: "bottom",
            barThickness: 25,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },

        scales: {
          y: {
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
          x: {
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },

            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },

        maintainAspectRatio: false,
      },
    },
    {
      id: "chart2",
      type: "bar",
      data: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],

        datasets: [
          {
            label: "Option A",
            data: [35, 59, 80, 81, 56, 55, 40],
            fill: false,
            backgroundColor: hexToRGB(colors.primary, 0.9),
            borderWidth: 2,
            borderColor: "transparent",
            barThickness: 20,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },

        scales: {
          y: {
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
          x: {
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },

            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },
        indexAxis: "y",
      },
    },
    {
      id: "chart3",
      type: "bar",
      data: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],
        datasets: [
          {
            label: " data one",
            data: [35, 59, 80, 81, 56, 55, 40],
            fill: false,
            backgroundColor: hexToRGB(colors.primary, 1),
            borderColor: colors.primary,

            borderSkipped: "bottom",
            barThickness: 40,
          },
          {
            label: " data two",
            data: [24, 42, 40, 19, 86, 27, 90],
            fill: false,
            backgroundColor: hexToRGB(colors.success, 1),
            borderColor: colors.success,

            borderSkipped: "bottom",
            barThickness: 40,
          },
          {
            label: " data three",
            data: [24, 42, 40, 19, 86, 27, 90],
            fill: false,
            backgroundColor: hexToRGB(colors.danger, 1),
            borderColor: colors.success,

            borderSkipped: "bottom",
            barThickness: 40,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },
        scales: {
          x: {
            stacked: true,
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },

            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
          y: {
            stacked: true,
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },

            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },
      },
    },
    {
      id: "chart4",
      type: "line",
      data: {
        labels: [
          0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140,
        ],
        datasets: [
          {
            label: " data one",
            data: [
              80, 150, 180, 270, 210, 160, 160, 202, 265, 210, 270, 255, 290,
              360, 375,
            ],
            fill: false,
            backgroundColor: hexToRGB(colors.primary, 1),
            borderColor: colors.primary,
            borderSkipped: "bottom",
            barThickness: 40,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: "transparent",
            lineTension: 0.5,
            pointStyle: "circle",
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
          },
          {
            label: " data two",
            data: [
              80, 125, 105, 130, 215, 195, 140, 160, 230, 300, 220, 170, 210,
              200, 280,
            ],
            fill: false,
            backgroundColor: hexToRGB(colors.success, 1),
            borderColor: colors.success,
            borderSkipped: "bottom",
            barThickness: 40,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: "transparent",
            lineTension: 0.5,
            pointStyle: "circle",
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
          },
          {
            label: " data three",
            data: [
              80, 99, 82, 90, 115, 115, 74, 75, 130, 155, 125, 90, 140, 130,
              180,
            ],
            fill: false,
            backgroundColor: hexToRGB(colors.danger, 1),
            borderColor: colors.danger,
            borderSkipped: "bottom",
            barThickness: 40,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: "transparent",
            lineTension: 0.5,
            pointStyle: "circle",
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            labels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },
        scales: {
          y: {
            stacked: true,
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
          x: {
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },

            ticks: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },
      },
    },
    {
      id: "chart5",
      type: "radar",
      data: {
        labels: [
          "Eating",
          "Drinking",
          "Sleeping",
          "Designing",
          "Coding",
          "Cycling",
          "Running",
        ],
        datasets: [
          {
            label: "My First Dataset",
            data: [65, 59, 90, 81, 56, 55, 40],
            fill: true,
            backgroundColor: colors.primary,
            borderColor: colors.primary,
          },
          {
            label: "My Second Dataset",
            data: [28, 48, 40, 19, 96, 27, 100],
            fill: true,
            backgroundColor: colors.success,
            borderColor: colors.success,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
          },
        },

        scales: {
          r: {
            ticks: {
              display: false,
              maxTicksLimit: 1,
              color: isDark ? "#cbd5e1" : "#475569",
            },
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
            pointLabels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
            angleLines: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
          },
        },
        maintainAspectRatio: false,
      },
    },
    {
      id: "chart6",
      type: "polarArea",
      data: {
        labels: ["primary", "success", "warning-500", "info", "danger"],
        datasets: [
          {
            label: "My First Dataset",
            data: [11, 16, 7, 3, 14],
            backgroundColor: [
              colors.primary,
              colors.success,
              colors.warning,
              colors.info,
              colors.danger,
            ],
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: {
              color: "#cbd5e1",
            },
          },
        },
        scales: {
          r: {
            ticks: {
              color: isDark ? "#475569" : "#475569",
            },
            grid: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
            pointLabels: {
              color: isDark ? "#cbd5e1" : "#475569",
            },
            angleLines: {
              color: isDark ? "#334155" : "#e2e8f0",
            },
          },
        },
        maintainAspectRatio: false,
      },
    },
  ];

  // loop through chartOptions array to render charts
  chartOptions.forEach(function (chart) {
    const ctx = document.getElementById(chart.id);
    if (ctx) {
      const chartObj = new ApexCharts(ctx, chart.options);
      chartObj.render();
    }
  });
  // loop through chartJsOptions array to render charts

  chartJsOptions.forEach(function (chart) {
    const ctx = document.getElementById(chart.id);
    if (ctx) {
      const chartObj = new Chart(ctx, {
        type: chart.type,
        data: chart.data,
        options: chart.options,
      });
    }
  });
  var randomId =
    Math.random().toString(36).substring(2, 15) +
    Math.random().toString(36).substring(2, 15);

  const chartWrapper = document.querySelectorAll(".donut-chart");
  // loop through each chart wrapper element
  chartWrapper.forEach((item, index) => {
    // generate a random ID for the chart element

    // create a new chart element with the generated ID
    var element = document.createElement("div");
    element.setAttribute("id", "donut-chart" + randomId + index);

    // set the height and width of the chart element (optional)
    var height = item.getAttribute("height") || 200;
    var width = item.getAttribute("width") || 200;
    var colors = item.getAttribute("colors").split(",");
    var hasLabel = item.getAttribute("hideLabel");
    var size = item.getAttribute("size") || "40%";

    // element.style.height = height + "px";
    // element.style.width = width + "px";

    // add the chart element to the wrapper element
    item.appendChild(element);

    // create a new instance of ApexCharts with the chart options and element ID
    var chartOptions = {
      chart: {
        type: "donut",
        height,
        toolbar: {
          show: false,
        },
      },
      series: [70, 30],
      labels: ["Complete", "Left"],
      dataLabels: {
        enabled: false,
      },
      plotOptions: {
        pie: {
          donut: {
            size,
            labels: {
              show: hasLabel ? false : true,
              name: {
                show: false,
                fontSize: "14px",
                fontWeight: "bold",
                fontFamily: "Inter",
              },
              value: {
                show: true,
                fontSize: "16px",
                fontFamily: "Outfit",
                color: isDark ? "#cbd5e1" : "#0f172a",
                formatter(val) {
                  return `${parseInt(val)}%`;
                },
              },
              total: {
                show: true,
                fontSize: "10px",
                label: "",
                formatter() {
                  return "70";
                },
              },
            },
          },
        },
      },
      colors: [...colors],
      legend: {
        show: false,
      },
    };
    // your chart options object
    var chart = new ApexCharts(
      document.querySelector("#donut-chart" + randomId + index),
      chartOptions
    );

    // render the chart
    chart.render();
  });
  const barChartWrapper = document.querySelectorAll(".bar-chart");
  barChartWrapper.forEach((item, index) => {
    var element = document.createElement("div");
    element.setAttribute("id", "barchart" + randomId + index);

    // set the height and width of the chart element (optional)
    var height = item.getAttribute("height") || 200;
    var width = item.getAttribute("width") || 200;
    var colors = item.getAttribute("colors").split(",");

    // add the chart element to the wrapper element
    item.appendChild(element);
    // create a new instance of ApexCharts with the chart options and element ID
    var chartOptions = {
      chart: {
        type: "bar",
        height: height,
        toolbar: {
          show: false,
        },
        offsetX: 0,
        offsetY: 0,
        zoom: {
          enabled: false,
        },
        sparkline: {
          enabled: true,
        },
      },
      series: [
        {
          name: "Revenue",
          data: [40, 70, 45, 100, 75, 40, 80, 90],
        },
      ],
      plotOptions: {
        bar: {
          columnWidth: "60px",
          barHeight: "100%",
        },
      },
      legend: {
        show: false,
      },

      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: "smooth",
        width: 2,
      },

      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return "$ " + val + "k";
          },
        },
      },
      yaxis: {
        show: false,
      },
      xaxis: {
        show: false,
        labels: {
          show: false,
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      colors: [...colors],
      grid: {
        show: false,
      },
    };
    // your chart options object
    var chart = new ApexCharts(
      document.querySelector("#barchart" + randomId + index),
      chartOptions
    );

    // render the chart
    chart.render();
  });
  const lineChartWrapper = document.querySelectorAll(".line-chart");
  lineChartWrapper.forEach((item, index) => {
    var element = document.createElement("div");
    element.setAttribute("id", "linechart" + randomId + index);

    // set the height and width of the chart element (optional)
    var height = item.getAttribute("height") || 200;
    var width = item.getAttribute("width") || 200;
    var colors = item.getAttribute("colors").split(",");

    // add the chart element to the wrapper element
    item.appendChild(element);
    // create a new instance of ApexCharts with the chart options and element ID
    var chartOptions = {
      chart: {
        type: "line",
        height: height,
        toolbar: {
          show: false,
        },
        offsetX: 0,
        offsetY: 0,
        zoom: {
          enabled: false,
        },
        sparkline: {
          enabled: true,
        },
      },
      series: [
        {
          data: [15, 30, 15, 30, 20, 35],
        },
      ],
      stroke: {
        width: [2],
        curve: "straight",
        dashArray: [0, 8, 5],
      },
      dataLabels: {
        enabled: false,
      },

      markers: {
        size: 4,
        colors: colors,
        strokeColors: colors,
        strokeWidth: 2,
        shape: "circle",
        radius: 2,
        hover: {
          sizeOffset: 1,
        },
      },

      yaxis: {
        show: false,
      },
      xaxis: {
        show: false,
        labels: {
          show: false,
        },
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
      },
      grid: {
        show: true,
        borderColor: isDark ? "#334155" : "#e2e8f0",
        strokeDashArray: 5,
        position: "back",
        xaxis: {
          lines: {
            show: true,
          },
        },
        yaxis: {
          lines: {
            show: false,
          },
        },
      },
      colors: [...colors],
    };
    // your chart options object
    var chart = new ApexCharts(
      document.querySelector("#linechart" + randomId + index),
      chartOptions
    );

    // render the chart
    chart.render();
  });
})(jQuery);
