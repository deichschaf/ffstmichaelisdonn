import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { WidgetLoaderProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';
import SVGIcon from '../../SVGIcon';

const PaulinchenEVInfo: React.FC<React.PropsWithChildren<WidgetLoaderProps>> = (
  props: WidgetLoaderProps,
): JSX.Element => {
  const link = 'https://www.paulinchen.de';
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <a href={link} target="_blank" rel="noreferrer">
            <SVGIcon svg="PaulinchenEV" alt="Paulinchen e.V." className="picture" />
          </a>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default PaulinchenEVInfo;
