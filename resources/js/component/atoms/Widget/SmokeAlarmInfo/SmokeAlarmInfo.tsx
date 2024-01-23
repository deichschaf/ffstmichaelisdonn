import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetLoaderProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import SVGIcon from '../../SVGIcon';

const SmokeAlarmInfo: React.FC<React.PropsWithChildren<WidgetLoaderProps>> = (
  props: WidgetLoaderProps,
): JSX.Element => {
  const link =
    'https://www.rauchmelder-lebensretter.de/rauchmelderpflicht/rauchmelderpflicht-schleswig-holstein/';
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <p>
            Die Einbaupflicht für Rauchmelder im Bundesland Schleswig-Holstein besteht seit dem
            01.01.2011. Alle wichtigen Informationen über die Notwendigkeit und den Betrieb von
            Rauchmeldern finden Sie
            <a href={link} target="_blank" rel="noreferrer">
              hier
            </a>
            .
          </p>
        </Col>
      </Row>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <a href={link} target="_blank" rel="noreferrer">
            <SVGIcon svg="SmokeAlarm" alt="Rauchmelder retten Leben" />
          </a>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default SmokeAlarmInfo;
