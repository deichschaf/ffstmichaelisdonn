import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { getGermanMonthName } from '../../../../../../acp/helper';
import { BuildEmergencyMonthProps } from '../../../../../../props/props';
import FAR from '../../../../../atoms/Icon/FAR';
import SVGIcon from '../../../../../atoms/SVGIcon';
import P from '../../../../../atoms/Typography/P';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const BuildEmergencyMonth: React.FC<React.PropsWithChildren<BuildEmergencyMonthProps>> = (
  props: BuildEmergencyMonthProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.month === 'undefined') {
    return <></>;
  }
  const { data } = props;
  const link = `/einsaetze/${props.year}/`;
  let url = '';
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="listcol tableBgColor">
          <P label={getGermanMonthName(props.month)} />
        </Col>
      </Row>
      {data.map((item, idx) => (
        <Row key={idx} className="colorchanger">
          <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={0} className="listcol">
            Nr {item.no}
          </Col>
          <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0} className="listcol">
            {item.beginn}
          </Col>
          <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={0} className="listcol">
            <Link reloadDocument={true} to={link + item.id} replace={true}>
              {item.einsatz_art}
            </Link>
          </Col>
          <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={0} className="listcol">
            {item.einsatz_ort}
          </Col>
          <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={0} className="listcol">
            {item.is_alarm === '1' ? (
              <SVGIcon svg="AlarmSignOn" alt="Melder alarm" className="ermergency_alarm" />
            ) : (
              <SVGIcon svg="AlarmSignOff" alt="Melder alarm" className="ermergency_alarm" />
            )}
          </Col>
          <Col xxl={1} xl={1} lg={1} md={1} sm={1} xs={0} className="listcol">
            <Link reloadDocument={true} to={link + item.id} replace={true}>
              <FAR className="folder-open" />
            </Link>
          </Col>
        </Row>
      ))}
    </ErrorBoundary>
  );
};
export default BuildEmergencyMonth;
