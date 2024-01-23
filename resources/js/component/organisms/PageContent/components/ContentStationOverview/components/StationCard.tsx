import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { StationCardProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import { Link } from 'react-router-dom';

const StationCard: React.FC<React.PropsWithChildren<StationCardProps>> = (
  props: StationCardProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  const link = `/fahrzeugdatenbank/ort/${data.id}/${data.clean_url}`;
  return (
    <ErrorBoundary>
      <Row className="colorchanger">
        <Col xxl={2} xl={2} lg={2} md={2} sm={12} xs={12}>
          <Link to={link}>
            <PictureSourcSet
              className="picture"
              img={data.img}
              path="/fahrzeuge/"
              images={data.images}
              alt={`${data.hi_org} ${data.hiort_name}`}
            />
          </Link>
        </Col>
        <Col xxl={10} xl={10} lg={10} md={10} sm={12} xs={12}>
          <Link to={link}>
            {data.hi_org} {data.hiort_name}
          </Link>{' '}
          <span className="color-grey">({data.fahrzeug_count})</span>
          <br />
          {data.funkrufnamen}
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default StationCard;
