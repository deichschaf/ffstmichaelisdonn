import React, { useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { FlyerboxProps } from '../../../../props/props';
import Countdown from '../../../molecules/Countdown';
import GridBox from '../../../molecules/GridBox';
import ErrorBoundary from '../../../organisms/errorboundary';
import DownloadLink from '../../Download/Link';
import PictureSourcSet from '../../Picture/SourceSet';
import P from '../../Typography/P';

const Flyerbox: React.FC<React.PropsWithChildren<FlyerboxProps>> = (
  props: FlyerboxProps,
): JSX.Element => {
  const [currentTime, setCurrentTime] = useState(Date.now());

  if (typeof props.data === 'undefined') {
    return <>Data leer</>;
  }
  if (typeof props.data.showuntil !== 'string') {
    return <>Showuntil</>;
  }
  const targetTime = Date.parse(props.data.showuntil);
  const timeBetween = targetTime - currentTime;
  if (timeBetween <= 0) {
    return <>Time</>;
  }
  const { data } = props;
  return (
    <ErrorBoundary>
      <GridBox lable={data.text}>
        <Row>
          <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
            <PictureSourcSet
              img={data.picture}
              images={data.images}
              path="/fileadmin/data/"
              className="picture"
            />
          </Col>
          <Col xxl={8} xl={8} lg={8} md={6} sm={6} xs={12}>
            <P label={data.content} />
            <DownloadLink
              href={data.href}
              linkText={data.linktext}
              target={data.target}
              icon={data.icon}
              size={data.size}
            />
            <Countdown datetime={data.datetime} />
          </Col>
        </Row>
      </GridBox>
    </ErrorBoundary>
  );
};
export default Flyerbox;
