import React from 'react';
import { Col, Row } from 'react-bootstrap';
import Globalvars from '../../../../../../globalvars';
import { StationDetailsProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import ContentArrayString from '../../ContentArrayString';
import ContentVehicle from '../../ContentVehicle';

const StationDetails: React.FC<React.PropsWithChildren<StationDetailsProps>> = (
  props: StationDetailsProps
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      {data.wachenbild !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PictureSourcSet
              className="picture"
              img={data.wachenbild.img}
              path={Globalvars.getFilePath() + '/fahrzeuge/'}
              images={data.wachenbild.images}
            />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.description !== '' && data.description !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <ContentArrayString content={data.description} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.links !== '' && data.links !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            Weitere Informationen finden Sie unter:{' '}
            <a href={data.links} target="_blank" rel="noreferrer">
              {data.links}
            </a>
          </Col>
        </Row>
      ) : (
        <></>
      )}
      <ContentVehicle data={data} />
    </ErrorBoundary>
  );
};
export default StationDetails;
