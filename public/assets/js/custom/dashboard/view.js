$(document).ready(function() {
    "use strict";
    let siteUrl = $('meta[name="site-url"]').attr('content');
    $.get(siteUrl + "/dashboard/get-chart-data", function(data, status){
        
        // Monthly Appointments Chart
        if (data.monthlyAppointments && data.monthlyAppointments.labels.length > 0) {
            var appointmentsChartCanvas = $('#appointmentsChart').get(0).getContext('2d');
            var appointmentsChartData = {
                labels: data.monthlyAppointments.labels,
                datasets: [{
                    label: 'Monthly Appointments',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data.monthlyAppointments.appointments
                }]
            };
            
            var appointmentsChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            
            new Chart(appointmentsChartCanvas, {
                type: 'line',
                data: appointmentsChartData,
                options: appointmentsChartOptions
            });
        }

        // Ward Distribution Chart
        if (data.wardDistribution && data.wardDistribution.wards.length > 0) {
            var wardChartCanvas = $('#wardChart').get(0).getContext('2d');
            var wardChartData = {
                labels: data.wardDistribution.wards,
                datasets: [{
                    label: 'Patients per Ward',
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    data: data.wardDistribution.patientCounts
                }]
            };
            
            var wardChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            
            new Chart(wardChartCanvas, {
                type: 'bar',
                data: wardChartData,
                options: wardChartOptions
            });
        }

        // Patient vs Doctors Ratio Chart
        if (data.patientDoctorRatio) {
            var ratioChartCanvas = $('#ratioChart').get(0).getContext('2d');
            var ratioChartData = {
                labels: ['Patients', 'Doctors'],
                datasets: [{
                    label: 'Count',
                    backgroundColor: ['rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1,
                    data: [data.patientDoctorRatio.patients, data.patientDoctorRatio.doctors]
                }]
            };
            
            var ratioChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };
            
            new Chart(ratioChartCanvas, {
                type: 'bar',
                data: ratioChartData,
                options: ratioChartOptions
            });
        }
        
        // Wellness Check Engagement Chart
        if (data.wellnessCheckStats && data.wellnessCheckStats.labels.length > 0) {
            var engagementChartCanvas = $('#engagementChart').get(0).getContext('2d');
            var engagementChartData = {
                labels: data.wellnessCheckStats.labels,
                datasets: [{
                    label: 'Average Engagement Score',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: true,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: data.wellnessCheckStats.engagementScores
                }]
            };
            
            var engagementChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            };
            
            new Chart(engagementChartCanvas, {
                type: 'line',
                data: engagementChartData,
                options: engagementChartOptions
            });
        }
    });
});
