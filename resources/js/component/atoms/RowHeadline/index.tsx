import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { RowHeadlineProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import H1 from '../Typography/H1';
import H2 from '../Typography/H2';
import H3 from '../Typography/H3';
import H4 from '../Typography/H4';
import H5 from '../Typography/H5';
import H6 from '../Typography/H6';
import P from '../Typography/P';

const RowHeadline: React.FC<React.PropsWithChildren<RowHeadlineProps>> = (
  props: RowHeadlineProps,
): JSX.Element => (
  <ErrorBoundary>
    <Row>
      <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12} />
      {props.headlineSize === 'undefined' ? <H4 label={props.label} /> : <></>}
      {props.headlineSize === 'h1' ? <H1 label={props.label} /> : <></>}
      {props.headlineSize === 'h2' ? <H2 label={props.label} /> : <></>}
      {props.headlineSize === 'h3' ? <H3 label={props.label} /> : <></>}
      {props.headlineSize === 'h4' ? <H4 label={props.label} /> : <></>}
      {props.headlineSize === 'h5' ? <H5 label={props.label} /> : <></>}
      {props.headlineSize === 'h6' ? <H6 label={props.label} /> : <></>}
      {props.headlineSize === 'p' ? <P label={props.label} /> : <></>}
    </Row>
  </ErrorBoundary>
);
export default RowHeadline;
