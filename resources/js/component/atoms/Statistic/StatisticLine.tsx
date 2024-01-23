import React from 'react';
import { Line } from 'react-chartjs-2';
import {
  CategoryScale,
  Chart as ChartJS,
  LayoutPosition,
  Legend,
  LinearScale,
  LineElement,
  PointElement,
  Title,
  Tooltip,
} from 'chart.js';
import { StatisticLineProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const StatisticLine: React.FC<React.PropsWithChildren<StatisticLineProps>> = (
  props: StatisticLineProps,
): JSX.Element => {
  ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend);

  const options = {
    responsive: true,
    plugins: {
      legend: {
        display: false,
      },
    },
    scales: {
      y: {
        min: 0,
        max: 10,
      },
    },
  };

  const labels = props.legende;

  const data = {
    labels,
    datasets: props.data,
  };

  return (
    <ErrorBoundary>
      <Line data={data} options={options} />
    </ErrorBoundary>
  );
};
export default StatisticLine;
