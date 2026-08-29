import ApexCharts from "apexcharts";

const getMainChartOptions = () => {
    let mainChartColors = {};

    if (document.documentElement.classList.contains("dark")) {
        mainChartColors = {
            borderColor: "#374151",
            labelColor: "#9CA3AF",
            opacityFrom: 0,
            opacityTo: 0.15,
        };
    } else {
        mainChartColors = {
            borderColor: "#F3F4F6",
            labelColor: "#6B7280",
            opacityFrom: 0.45,
            opacityTo: 0,
        };
    }

    return {
        chart: {
            height: 420,
            type: "area",
            fontFamily: "Inter, sans-serif",
            foreColor: mainChartColors.labelColor,
            toolbar: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                enabled: true,
                opacityFrom: mainChartColors.opacityFrom,
                opacityTo: mainChartColors.opacityTo,
            },
        },
        dataLabels: {
            enabled: false,
        },
        tooltip: {
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
        grid: {
            show: true,
            borderColor: mainChartColors.borderColor,
            strokeDashArray: 1,
            padding: {
                left: 35,
                bottom: 15,
            },
        },
        series: [
            {
                name: "Revenue",
                data: [6356, 6218, 6156, 6526, 6356, 6256, 6056],
                color: "#1A56DB",
            },
            {
                name: "Revenue (previous period)",
                data: [6556, 6725, 6424, 6356, 6586, 6756, 6616],
                color: "#FDBA8C",
            },
        ],
        markers: {
            size: 5,
            strokeColors: "#ffffff",
            hover: {
                size: undefined,
                sizeOffset: 3,
            },
        },
        xaxis: {
            categories: [
                "01 Feb",
                "02 Feb",
                "03 Feb",
                "04 Feb",
                "05 Feb",
                "06 Feb",
                "07 Feb",
            ],
            labels: {
                style: {
                    colors: [mainChartColors.labelColor],
                    fontSize: "14px",
                    fontWeight: 500,
                },
            },
            axisBorder: {
                color: mainChartColors.borderColor,
            },
            axisTicks: {
                color: mainChartColors.borderColor,
            },
            crosshairs: {
                show: true,
                position: "back",
                stroke: {
                    color: mainChartColors.borderColor,
                    width: 1,
                    dashArray: 10,
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: [mainChartColors.labelColor],
                    fontSize: "14px",
                    fontWeight: 500,
                },
                formatter: function (value) {
                    return "$" + value;
                },
            },
        },
        legend: {
            fontSize: "14px",
            fontWeight: 500,
            fontFamily: "Inter, sans-serif",
            labels: {
                colors: [mainChartColors.labelColor],
            },
            itemMargin: {
                horizontal: 10,
            },
        },
        responsive: [
            {
                breakpoint: 1024,
                options: {
                    xaxis: {
                        labels: {
                            show: false,
                        },
                    },
                },
            },
        ],
    };
};

if (document.getElementById("main-chart")) {
    const chart = new ApexCharts(
        document.getElementById("main-chart"),
        getMainChartOptions(),
    );
    chart.render();

    // init again when toggling dark mode
    document.addEventListener("dark-mode", function () {
        chart.updateOptions(getMainChartOptions());
    });
}

if (document.getElementById("new-products-chart")) {
    const options = {
        colors: ["#1A56DB", "#FDBA8C"],
        series: [
            {
                name: "Quantity",
                color: "#1A56DB",
                data: [
                    { x: "01 Feb", y: 170 },
                    { x: "02 Feb", y: 180 },
                    { x: "03 Feb", y: 164 },
                    { x: "04 Feb", y: 145 },
                    { x: "05 Feb", y: 194 },
                    { x: "06 Feb", y: 170 },
                    { x: "07 Feb", y: 155 },
                ],
            },
        ],
        chart: {
            type: "bar",
            height: "140px",
            fontFamily: "Inter, sans-serif",
            foreColor: "#4B5563",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                columnWidth: "90%",
                borderRadius: 3,
            },
        },
        tooltip: {
            shared: false,
            intersect: false,
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 5,
            colors: ["transparent"],
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            floating: false,
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
        yaxis: {
            show: false,
        },
        fill: {
            opacity: 1,
        },
    };

    const chart = new ApexCharts(
        document.getElementById("new-products-chart"),
        options,
    );
    chart.render();
}

if (document.getElementById("sales-by-category")) {
    const options = {
        colors: ["#1A56DB", "#FDBA8C"],
        series: [
            {
                name: "Desktop PC",
                color: "#1A56DB",
                data: [
                    { x: "01 Feb", y: 170 },
                    { x: "02 Feb", y: 180 },
                    { x: "03 Feb", y: 164 },
                    { x: "04 Feb", y: 145 },
                    { x: "05 Feb", y: 194 },
                    { x: "06 Feb", y: 170 },
                    { x: "07 Feb", y: 155 },
                ],
            },
            {
                name: "Phones",
                color: "#FDBA8C",
                data: [
                    { x: "01 Feb", y: 120 },
                    { x: "02 Feb", y: 294 },
                    { x: "03 Feb", y: 167 },
                    { x: "04 Feb", y: 179 },
                    { x: "05 Feb", y: 245 },
                    { x: "06 Feb", y: 182 },
                    { x: "07 Feb", y: 143 },
                ],
            },
            {
                name: "Gaming/Console",
                color: "#17B0BD",
                data: [
                    { x: "01 Feb", y: 220 },
                    { x: "02 Feb", y: 194 },
                    { x: "03 Feb", y: 217 },
                    { x: "04 Feb", y: 279 },
                    { x: "05 Feb", y: 215 },
                    { x: "06 Feb", y: 263 },
                    { x: "07 Feb", y: 183 },
                ],
            },
        ],
        chart: {
            type: "bar",
            height: "420px",
            fontFamily: "Inter, sans-serif",
            foreColor: "#4B5563",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                columnWidth: "90%",
                borderRadius: 3,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 5,
            colors: ["transparent"],
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            floating: false,
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
        yaxis: {
            show: false,
        },
        fill: {
            opacity: 1,
        },
    };

    const chart = new ApexCharts(
        document.getElementById("sales-by-category"),
        options,
    );
    chart.render();
}

const getVisitorsChartOptions = () => {
    let visitorsChartColors = {};

    if (document.documentElement.classList.contains("dark")) {
        visitorsChartColors = {
            fillGradientShade: "dark",
            fillGradientShadeIntensity: 0.45,
        };
    } else {
        visitorsChartColors = {
            fillGradientShade: "light",
            fillGradientShadeIntensity: 1,
        };
    }

    return {
        series: [
            {
                name: "Visitors",
                data: [500, 590, 600, 520, 610, 550, 600],
            },
        ],
        labels: [
            "01 Feb",
            "02 Feb",
            "03 Feb",
            "04 Feb",
            "05 Feb",
            "06 Feb",
            "07 Feb",
        ],
        chart: {
            type: "area",
            height: "305px",
            fontFamily: "Inter, sans-serif",
            sparkline: {
                enabled: true,
            },
            toolbar: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: visitorsChartColors.fillGradientShade,
                shadeIntensity: visitorsChartColors.fillGradientShadeIntensity,
            },
        },
        plotOptions: {
            area: {
                fillTo: "end",
            },
        },
        theme: {
            monochrome: {
                enabled: true,
                color: "#1A56DB",
            },
        },
        tooltip: {
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
    };
};

const getSignupsChartOptions = () => {
    let signupsChartColors = {};

    if (document.documentElement.classList.contains("dark")) {
        signupsChartColors = {
            backgroundBarColors: [
                "#374151",
                "#374151",
                "#374151",
                "#374151",
                "#374151",
                "#374151",
                "#374151",
            ],
        };
    } else {
        signupsChartColors = {
            backgroundBarColors: [
                "#E5E7EB",
                "#E5E7EB",
                "#E5E7EB",
                "#E5E7EB",
                "#E5E7EB",
                "#E5E7EB",
                "#E5E7EB",
            ],
        };
    }

    return {
        series: [
            {
                name: "Users",
                data: [1334, 2435, 1753, 1328, 1155, 1632, 1336],
            },
        ],
        labels: [
            "01 Feb",
            "02 Feb",
            "03 Feb",
            "04 Feb",
            "05 Feb",
            "06 Feb",
            "07 Feb",
        ],
        chart: {
            type: "bar",
            height: "140px",
            foreColor: "#4B5563",
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false,
            },
        },
        theme: {
            monochrome: {
                enabled: true,
                color: "#1A56DB",
            },
        },
        plotOptions: {
            bar: {
                columnWidth: "25%",
                borderRadius: 3,
                colors: {
                    backgroundBarColors: signupsChartColors.backgroundBarColors,
                    backgroundBarRadius: 3,
                },
            },
            dataLabels: {
                hideOverflowingLabels: false,
            },
        },
        xaxis: {
            floating: false,
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
        tooltip: {
            shared: true,
            intersect: false,
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 0.8,
                },
            },
        },
        fill: {
            opacity: 1,
        },
        yaxis: {
            show: false,
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
    };
};

if (document.getElementById("week-signups-chart")) {
    const chart = new ApexCharts(
        document.getElementById("week-signups-chart"),
        getSignupsChartOptions(),
    );
    chart.render();

    // init again when toggling dark mode
    document.addEventListener("dark-mode", function () {
        chart.updateOptions(getSignupsChartOptions());
    });
}

const getTrafficChannelsChartOptions = () => {
    let trafficChannelsChartColors = {};

    if (document.documentElement.classList.contains("dark")) {
        trafficChannelsChartColors = {
            strokeColor: "#1f2937",
        };
    } else {
        trafficChannelsChartColors = {
            strokeColor: "#ffffff",
        };
    }

    return {
        series: [70, 5, 25],
        labels: ["Desktop", "Tablet", "Phone"],
        colors: ["#16BDCA", "#FDBA8C", "#1A56DB"],
        chart: {
            type: "donut",
            height: 400,
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false,
            },
        },
        responsive: [
            {
                breakpoint: 430,
                options: {
                    chart: {
                        height: 300,
                    },
                },
            },
        ],
        stroke: {
            colors: [trafficChannelsChartColors.strokeColor],
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 0.9,
                },
            },
        },
        tooltip: {
            shared: true,
            followCursor: false,
            fillSeriesColor: false,
            inverseOrder: true,
            style: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
            },
            x: {
                show: true,
                formatter: function (_, { seriesIndex, w }) {
                    const label = w.config.labels[seriesIndex];
                    return label;
                },
            },
            y: {
                formatter: function (value) {
                    return value + "%";
                },
            },
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
    };
};

if (document.getElementById("traffic-by-device")) {
    const chart = new ApexCharts(
        document.getElementById("traffic-by-device"),
        getTrafficChannelsChartOptions(),
    );
    chart.render();

    // init again when toggling dark mode
    document.addEventListener("dark-mode", function () {
        chart.updateOptions(getTrafficChannelsChartOptions());
    });
}

// ================================================================
// Dashboard Helpdesk Charts (from _chartData)
// ================================================================
if (window._chartData) {
    const chartColors = document.documentElement.classList.contains("dark")
        ? { label: "#9CA3AF", border: "#374151" }
        : { label: "#6B7280", border: "#F3F4F6" };

    // --- Monthly Trend Chart (Area) ---
    if (document.getElementById("monthly-trend-chart")) {
        const options = {
            chart: {
                height: 350,
                type: "area",
                fontFamily: "Inter, sans-serif",
                foreColor: chartColors.label,
                toolbar: { show: false },
            },
            fill: {
                type: "gradient",
                gradient: {
                    enabled: true,
                    opacityFrom: 0.45,
                    opacityTo: 0,
                },
            },
            dataLabels: { enabled: false },
            tooltip: {
                style: { fontSize: "14px", fontFamily: "Inter, sans-serif" },
            },
            grid: {
                show: true,
                borderColor: chartColors.border,
                strokeDashArray: 1,
                padding: { left: 35, bottom: 15 },
            },
            series: [
                {
                    name: "Tiket",
                    data: window._chartData.monthlyTotals,
                    color: "#1A56DB",
                },
            ],
            markers: {
                size: 5,
                strokeColors: "#ffffff",
                hover: { size: undefined, sizeOffset: 3 },
            },
            xaxis: {
                categories: window._chartData.months,
                labels: {
                    style: {
                        colors: [chartColors.label],
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                },
                axisBorder: { color: chartColors.border },
                axisTicks: { color: chartColors.border },
                crosshairs: {
                    show: true,
                    position: "back",
                    stroke: {
                        color: chartColors.border,
                        width: 1,
                        dashArray: 10,
                    },
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: [chartColors.label],
                        fontSize: "12px",
                        fontWeight: 500,
                    },
                    formatter: function (value) {
                        return value;
                    },
                },
            },
            legend: {
                fontSize: "14px",
                fontWeight: 500,
                fontFamily: "Inter, sans-serif",
                labels: { colors: [chartColors.label] },
                itemMargin: { horizontal: 10 },
            },
        };

        const chart = new ApexCharts(
            document.getElementById("monthly-trend-chart"),
            options,
        );
        chart.render();

        document.addEventListener("dark-mode", function () {
            chart.updateOptions(options);
        });
    }

    // --- Category Chart (Bar) ---
    if (document.getElementById("category-chart")) {
        const catColors = [
            "#1A56DB",
            "#FDBA8C",
            "#17B0BD",
            "#E74694",
            "#7E3AF2",
            "#F05252",
            "#0E9F6E",
            "#FF5A1F",
        ];
        const catSeries = window._chartData.categories.map((name, i) => ({
            x: name,
            y: window._chartData.categoryTotals[i],
        }));

        const options = {
            colors: catColors,
            series: [{ name: "Tiket", color: "#1A56DB", data: catSeries }],
            chart: {
                type: "bar",
                height: "250px",
                fontFamily: "Inter, sans-serif",
                foreColor: chartColors.label,
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    columnWidth: "90%",
                    borderRadius: 3,
                },
            },
            tooltip: {
                shared: false,
                intersect: false,
                style: { fontSize: "14px", fontFamily: "Inter, sans-serif" },
            },
            states: {
                hover: {
                    filter: { type: "darken", value: 1 },
                },
            },
            stroke: {
                show: true,
                width: 5,
                colors: ["transparent"],
            },
            grid: { show: false },
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                floating: false,
                labels: { show: false },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: { show: false },
            fill: { opacity: 1 },
        };

        const chart = new ApexCharts(
            document.getElementById("category-chart"),
            options,
        );
        chart.render();
    }

    // --- Priority Chart (Donut) ---
    if (document.getElementById("priority-chart")) {
        const prioColors = {
            high: "#F05252",
            medium: "#FDBA8C",
            low: "#0E9F6E",
        };
        const prioLabels = window._chartData.priorities.map(
            (p) => window._chartData.priorityLabels[p] || p,
        );
        const prioData = window._chartData.priorityTotals;
        const colors = window._chartData.priorities.map(
            (p) => prioColors[p] || "#6B7280",
        );

        const options = {
            series: prioData,
            labels: prioLabels,
            colors: colors,
            chart: {
                type: "donut",
                height: 250,
                fontFamily: "Inter, sans-serif",
                toolbar: { show: false },
            },
            responsive: [
                {
                    breakpoint: 430,
                    options: { chart: { height: 200 } },
                },
            ],
            stroke: {
                colors: document.documentElement.classList.contains("dark")
                    ? ["#1f2937"]
                    : ["#ffffff"],
            },
            states: {
                hover: {
                    filter: { type: "darken", value: 0.9 },
                },
            },
            tooltip: {
                shared: true,
                followCursor: false,
                fillSeriesColor: false,
                inverseOrder: true,
                style: { fontSize: "14px", fontFamily: "Inter, sans-serif" },
                y: {
                    formatter: function (value) {
                        return value + " tiket";
                    },
                },
            },
            grid: { show: false },
            dataLabels: { enabled: false },
            legend: { show: false },
        };

        const chart = new ApexCharts(
            document.getElementById("priority-chart"),
            options,
        );
        chart.render();
    }
}
