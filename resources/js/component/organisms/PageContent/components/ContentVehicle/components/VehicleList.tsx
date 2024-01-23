import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../../../../globalvars';
import { VehicleListProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const VehicleList: React.FC<React.PropsWithChildren<VehicleListProps>> = (
  props: VehicleListProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  const link = `/fahrzeugdatenbank/fahrzeug/${data.id}/title/${data.type_url}`;
  return (
    <ErrorBoundary>
      <Row className="colorchanger">
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          <Link to={link}>
            <PictureSourcSet
              className="picture"
              img={data.img}
              path={Globalvars.getFilePath() + '/fahrzeuge/'}
              images={data.images}
            />
          </Link>
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          {data.bos_kennung}
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          <Link to={link}>{data.fahrzeug}</Link>
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          <Link to={link}>{data.fahrgestell}</Link>
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          {data.baujahr}
        </Col>
        <Col xxl={2} xl={2} lg={2} md={2} sm={2} xs={0}>
          <Link to={link}>{data.kennzeichen}</Link>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default VehicleList;
