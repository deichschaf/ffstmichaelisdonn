import React, { CSSProperties } from 'react';
import { AdminStatisticProps } from '../../../props/props';
import ButtonFAS from '../../atoms/Buttons/ButtonFAS';
import FAS from '../../atoms/Icon/FAS';
import ErrorBoundary from '../../organisms/errorboundary';

const AdminStatistic: React.FC<React.PropsWithChildren<AdminStatisticProps>> = (
  props: AdminStatisticProps,
): JSX.Element => {
  function getWidth(percent) {
    const width = `width: ${percent}%`;
    return width as CSSProperties;
  }

  const percent = (props.statistic.count * 100) / props.statistic.count_max;

  return (
    <ErrorBoundary>
      <div className={`tiles m-b-10 added-margin ${props.color}`}>
        <div className="tiles-body">
          <div className="tiles-title"> {props.statistic.title} </div>
          <div className="heading">
            <span
              className="animate-number"
              data-value="{props.statistic.count}"
              data-animation-duration="1000"
            >
              {props.statistic.count_comma} /{props.statistic.count_max}
            </span>
          </div>
          <div className="progress transparent progress-small no-radius">
            <div
              className="progress-bar progress-bar-white animate-progress-bar"
              data-percentage="{props.statistic.percent}%"
              style={{ width: `${percent}%` }}
            />
          </div>
          <div className="description">
            <FAS className="icon-custom-up" />
            <span className="text-white mini-description ">
              &nbsp; {percent.toFixed(2)}% <span className="blend">bisher umgesetzt</span>
            </span>
          </div>
        </div>
      </div>
    </ErrorBoundary>
  );
};
export default AdminStatistic;
