import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { StatisticBoxAreaProps } from '../../../props/props';
import StatisticBox from '../../molecules/StatisticBox';
import StatisticBoxEmergency from '../../molecules/StatisticBox/StatisticBoxEmergency';
import ErrorBoundary from '../errorboundary';

const StatisticBoxArea: React.FC<React.PropsWithChildren<StatisticBoxAreaProps>> = (
  props: StatisticBoxAreaProps,
): JSX.Element => {
  const active_member = 32;
  const square_meter = '21,58';
  const population = 503;
  if (typeof props.data.statistic === 'undefined') {
    return <></>;
  }
  const { statistic } = props.data;
  const firedepartmentstatistic = statistic.fire_department_statistic;
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={4} xl={4} lg={4} md={4} sm={6} xs={12}>
          <StatisticBoxEmergency
            symbol="fire"
            title={`${firedepartmentstatistic.alarms_this_year} Einsätze in ${firedepartmentstatistic.alarms_this_year_date}`}
            text={`Aktuell haben wir bisher ${firedepartmentstatistic.alarms_this_year} Einsätze in diesem Jahr gehabt.`}
            lastalarm={firedepartmentstatistic.alarm_last_date}
            link="/einsaetze"
            linkText={`Einsätze ${firedepartmentstatistic.alarms_this_year_date}`}
          />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={6} xs={12}>
          <StatisticBox
            symbol="users"
            title={`${active_member} aktive Einsatzkräfte`}
            text={`Mit aktuell ${active_member} Einsatzkräften sind wir in Sankt Michaelisdonn 24/7/365 für Sie da.`}
            link=""
            linkText=""
          />
        </Col>
        <Col xxl={4} xl={4} lg={4} md={4} sm={6} xs={12}>
          <StatisticBox
            symbol="map-location-dot"
            title={`${square_meter} km² Fläche`}
            text={`Unser Einsatzgebiet Sankt Michaelisdonn/Ramhusen erstreckt sich über eine Fläche von ${square_meter} km² und über ${population} Einwohnern.`}
            link=""
            linkText=""
          />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default StatisticBoxArea;
