import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { FooterEmergencyProps } from '../../../../props/props';
import FAS from '../../../atoms/Icon/FAS';
import ErrorBoundary from '../../errorboundary';

const FooterEmergency: React.FC<React.PropsWithChildren<FooterEmergencyProps>> = (
  props: FooterEmergencyProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.fire_department_statistic === 'undefined') {
    return <></>;
  }
  const statistic = props.data.fire_department_statistic;
  return (
    <ErrorBoundary>
      <h4 className="headline">Statistik</h4>
      <ul className="big">
        <li>
          <p className="text">
            <FAS className="truck-moving" /> Fahrzeuge:
            {statistic.trucks}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="trailer" /> Anhänger:
            {statistic.trailer}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="people-group" /> Mitglieder:
            {statistic.active_user}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="person" /> Kameraden:
            {statistic.user_person}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="person-dress" /> Kameradinnen:
            {statistic.user_personwoman}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="pager" /> Einsätze ({statistic.alarms_this_year_date}
            ): {statistic.alarms_this_year}
          </p>
        </li>
        <li>
          <p className="text">
            <FAS className="pager" /> Einsätze ({statistic.alarms_last_year_date}
            ): {statistic.alarms_last_year}
          </p>
        </li>
      </ul>
    </ErrorBoundary>
  );
};
export default FooterEmergency;
