import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { ContentEmergencyProps } from '../../../../../props/props';
import ErrorBoundary from '../../../errorboundary';
import BuildEmergencyYear from './modules/BuildEmergencyYear';
import YearSelector from './modules/YearSelector';

const ContentEmergency: React.FC<React.PropsWithChildren<ContentEmergencyProps>> = (
  props: ContentEmergencyProps,
): JSX.Element => {
  const [showYear, setYear] = useState<number>(0);
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.emergency === 'undefined') {
    return <></>;
  }
  const activeYear = new Date().getFullYear();
  if (showYear === 0) {
    setYear(activeYear);
  }

  const handleYear = (val: number) => {
    setYear(val);
  };

  const data = props.data.emergency;
  const years = [] as any;
  Object.values(data.years).map(year => years.push(year));

  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <YearSelector years={years} active={showYear} handleYear={handleYear} />
        </Col>
      </Row>
      <BuildEmergencyYear
        year={showYear}
        data={data.entries[showYear]}
        statistic={data.statistics[showYear]}
      />
    </ErrorBoundary>
  );
};
export default ContentEmergency;
