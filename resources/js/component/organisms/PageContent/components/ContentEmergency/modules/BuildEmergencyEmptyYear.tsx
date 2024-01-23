import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { BuildEmergencyEmptyProps } from '../../../../../../props/props';
import P from '../../../../../atoms/Typography/P';
import ErrorBoundary from '../../../../errorboundary';

const BuildEmergencyEmpty: React.FC<React.PropsWithChildren<BuildEmergencyEmptyProps>> = (
  props: BuildEmergencyEmptyProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
        <P label="Keine Einsätze vorhanden." />
      </Col>
    </Row>
  </ErrorBoundary>
);
export default BuildEmergencyEmpty;
