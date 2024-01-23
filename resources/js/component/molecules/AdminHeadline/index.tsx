import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { AdminHeadlineProps } from '../../../props/props';
import PageHeadline from '../../atoms/PageHeadline';
import ErrorBoundary from '../../organisms/errorboundary';

const AdminHeadline: React.FC<React.PropsWithChildren<AdminHeadlineProps>> = (
  props: AdminHeadlineProps,
): JSX.Element => (
  <ErrorBoundary>
    <div className="overview_headline">
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <PageHeadline label={props.label} />
        </Col>
      </Row>
    </div>
  </ErrorBoundary>
);
export default AdminHeadline;
