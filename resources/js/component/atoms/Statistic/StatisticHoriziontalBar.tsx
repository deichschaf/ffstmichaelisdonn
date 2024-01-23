import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { Bar } from 'react-chartjs-2';
import {
  ArcElement,
  BarElement,
  CategoryScale,
  Chart as ChartJS,
  Legend,
  LinearScale,
  Title,
  Tooltip,
} from 'chart.js';
import { StatisticHoriziontalBarProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const StatisticHoriziontalBar: React.FC<React.PropsWithChildren<StatisticHoriziontalBarProps>> = (
  props: StatisticHoriziontalBarProps,
): JSX.Element => {
  ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

  const options = {
    indexAxis: 'y' as const,
    elements: {
      bar: {
        borderWidth: 2,
      },
    },
    responsive: true,
  };

  const labels = props.legende;

  const data = {
    labels,
    datasets: props.data,
    // datasets: [
    //   // {
    //   //   label: 'Dataset 1',
    //   //   data: labels.map(() => faker.datatype.number({ min: -1000, max: 1000 })),
    //   //   borderColor: 'rgb(255, 99, 132)',
    //   //   backgroundColor: 'rgba(255, 99, 132, 0.5)',
    //   // },
    //   // {
    //   //   label: 'Dataset 2',
    //   //   data: labels.map(() => faker.datatype.number({ min: -1000, max: 1000 })),
    //   //   borderColor: 'rgb(53, 162, 235)',
    //   //   backgroundColor: 'rgba(53, 162, 235, 0.5)',
    //   // },
    // ],
  };

  return (
    <ErrorBoundary>
      <Bar data={data} options={options} />
    </ErrorBoundary>
  );
};
export default StatisticHoriziontalBar;
