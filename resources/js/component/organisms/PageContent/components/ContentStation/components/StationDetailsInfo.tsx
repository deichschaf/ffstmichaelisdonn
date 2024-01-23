import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { StationDetailsInfoProps } from '../../../../../../props/props';
import PictureSourcSet from '../../../../../atoms/Picture/SourceSet';
import ErrorBoundary from '../../../../errorboundary';
import ContentArrayString from '../../ContentArrayString';

const StationDetailsInfo: React.FC<React.PropsWithChildren<StationDetailsInfoProps>> = (
  props: StationDetailsInfoProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <PictureSourcSet
            className="picture"
            img={`${data.id}.gif`}
            path="/fahrzeuge/"
            alt="Dithmarschen Position"
          />
        </Col>
      </Row>
      {data.wappen !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <PictureSourcSet
              className="picture"
              img={data.wappen.img}
              path="/fahrzeuge/"
              images={data.wappen.images}
            />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.bos_unit !== '' && data.bos_unit !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <ContentArrayString content={data.bos_unit} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.street !== '' && data.street !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <ContentArrayString content={data.street} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.city !== '' && data.city !== null ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <ContentArrayString content={data.city} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.wachenbilder.length > 0 ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            {props.data.wachenbilder.map((item, idx) => (
              <PictureSourcSet
                key={idx}
                className="picture"
                img={item.img}
                path="/fahrzeuge/"
                images={item.images}
              />
            ))}
          </Col>
        </Row>
      ) : (
        <></>
      )}
    </ErrorBoundary>
  );
};
export default StationDetailsInfo;
