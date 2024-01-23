import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { FooterFlodithStatisticProps } from '../../../../props/props';
import FAS from '../../../atoms/Icon/FAS';

const FooterFlodithStatistic: React.FC<React.PropsWithChildren<FooterFlodithStatisticProps>> = (
  props: FooterFlodithStatisticProps,
): JSX.Element => {
  if (typeof props.footer === 'undefined') {
    return <></>;
  }
  if (typeof props.footer.flodith === 'undefined') {
    return <></>;
  }
  return (
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} className="fbox">
        <h4 className="headline">Statistik</h4>
        <ul className="big">
          <li>
            <p className="text">
              <FAS className="truck-moving" /> Fahrzeuge:
              {props.footer.flodith.statistic.vehicle}
            </p>
          </li>
          <li>
            <p className="text">
              <FAS className="house" /> Standorte:
              {props.footer.flodith.statistic.standorte}
            </p>
          </li>
          <li>
            <p className="text">
              <FAS className="camera" /> Bilder:
              {props.footer.flodith.statistic.images}
            </p>
          </li>
        </ul>
      </Col>
    </Row>
  );
};
export default FooterFlodithStatistic;
