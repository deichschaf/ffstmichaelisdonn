import React from 'react';
import { Bar } from 'react-chartjs-2';
import {
  BarElement,
  CategoryScale,
  Chart as ChartJS,
  Legend,
  LinearScale,
  Title,
  Tooltip,
} from 'chart.js';
import { StatisticVerticalBarProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const StatisticVerticalBar: React.FC<React.PropsWithChildren<StatisticVerticalBarProps>> = (
  props: StatisticVerticalBarProps,
): JSX.Element => {
  ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

  const options = {
    responsive: true,
    // plugins: {
    //   legend: {
    //     position: 'right' as LayoutPosition,
    //   },
    // },
  };

  const labels = props.legende;

  const data = {
    labels,
    datasets: props.data,
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)',
    ],
    borderWidth: 1,
  };

  return (
    <ErrorBoundary>
      <Bar data={data} options={options} />
    </ErrorBoundary>
  );
};
export default StatisticVerticalBar;
