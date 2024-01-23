import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import AlertOfflineBox from '../../../component/molecules/AlertBox/Online';
import GridSimple from '../../../component/molecules/GridSimple';
import MapComponent from '../../../component/molecules/MapComponent';
import ErrorBoundary from '../../../component/organisms/errorboundary';
import { EmergencyMapProps } from '../../../props/props';

const EmergencyMap: React.FC<React.PropsWithChildren<EmergencyMapProps>> = (
  props: EmergencyMapProps,
): JSX.Element => {
  const [getSync, setSync] = useState<boolean>(false);
  useEffect(() => {
    async function fetchMyApi() {
      const response = await fetch('/api/checkOffline');
      const responseData = await response.json();
      setSync(responseData.success);
    }
    fetchMyApi();
  }, []);

  if (typeof props.lat === 'undefined' || typeof props.lon === 'undefined') {
    return <></>;
  }
  if (props.lat === null || props.lat === 0 || props.lon === null || props.lon === 0) {
    return <></>;
  }
  if (!getSync) {
    return (
      <ErrorBoundary>
        <Row>
          <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
            <GridSimple>
              <AlertOfflineBox />
            </GridSimple>
          </Col>
        </Row>
      </ErrorBoundary>
    );
  }

  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <GridSimple>
            <MapComponent lat={props.lat} lon={props.lon} />
          </GridSimple>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default EmergencyMap;
