import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { Pie } from 'react-chartjs-2';
import { ArcElement, Chart as ChartJS, LayoutPosition, Legend, Tooltip } from 'chart.js';
import { StatisticPieProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const StatisticPie: React.FC<React.PropsWithChildren<StatisticPieProps>> = (
  props: StatisticPieProps,
): JSX.Element => {
  ChartJS.register(ArcElement, Tooltip, Legend);

  const data = {
    labels: props.legende,
    datasets: [
      {
        label: '# of Votes',
        data: props.data,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
        ],
        borderWidth: 1,
      },
    ],
  };

  return (
    <ErrorBoundary>
      <Pie data={data} />
    </ErrorBoundary>
  );
};
export default StatisticPie;
