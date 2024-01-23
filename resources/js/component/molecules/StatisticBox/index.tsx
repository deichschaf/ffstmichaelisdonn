import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { StatisticBoxProps } from '../../../props/props';
import FAS from '../../atoms/Icon/FAS';
import Link from '../../atoms/Link';
import H3 from '../../atoms/Typography/H3';
import P from '../../atoms/Typography/P';
import ErrorBoundary from '../../organisms/errorboundary';

const StatisticBox: React.FC<React.PropsWithChildren<StatisticBoxProps>> = (
  props: StatisticBoxProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="statisticBox">
      <div className="iconarea">
        <div className="icon">
          <FAS className={props.symbol} />
        </div>
        <div className="infoBoxContent">
          <H3 label={props.title} />
          <P label={props.text} />
          {props.link !== null && props.link !== '' ? (
            <Link
              className="btn btn-sm btn-outline-danger"
              title={props.linkText}
              href={props.link}
            />
          ) : (
            <></>
          )}
        </div>
      </div>
    </div>
  </ErrorBoundary>
);
export default StatisticBox;
