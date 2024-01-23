import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentStationProps } from '../../../../../props/props';
import H1 from '../../../../atoms/Typography/H1';
import H2 from '../../../../atoms/Typography/H2';
import useDocumentTitle from '../../../../useHooks/useDocumentTitle';
import ErrorBoundary from '../../../errorboundary';
import StationDetails from './components/StationDetails';
import StationDetailsInfo from './components/StationDetailsInfo';

const ContentStation: React.FC<React.PropsWithChildren<ContentStationProps>> = (
  props: ContentStationProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.params === 'undefined') {
    return <></>;
  }
  const data = props.data.vehicle_database;
  useDocumentTitle(data.unit);
  return (
    <ErrorBoundary>
      {data.unit !== '' ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H1 label={data.unit} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      {data.bos_kennung !== '' ? (
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <H2 label={data.bos_kennung} />
          </Col>
        </Row>
      ) : (
        <></>
      )}
      <Row>
        <Col xxl={9} xl={9} lg={9} md={9} sm={12} xs={12}>
          <StationDetails data={data} />
        </Col>
        <Col xxl={3} xl={3} lg={3} md={3} sm={12} xs={12}>
          <StationDetailsInfo data={data} />
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default ContentStation;
