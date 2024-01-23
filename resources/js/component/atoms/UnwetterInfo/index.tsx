import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { UnwetterInfoProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import NationalWarnSign from '../../svgs/schutzzeichen.svg';
import FAR from '../Icon/FAR';
import PictureSourcSet from '../Picture/SourceSet';
import SVGIcon from '../SVGIcon';
import WeatherMessage from './modules/WeatherMessage';

const UnwetterInfo: React.FC<React.PropsWithChildren<UnwetterInfoProps>> = (
  props: UnwetterInfoProps,
): JSX.Element => {
  if (typeof props.data === 'undefined') {
    return <></>;
  }
  if (typeof props.data.weather === 'undefined') {
    return <></>;
  }
  if (props.data.weather.warnungen.length === 0 && props.data.weather.vorabinfo.length === 0) {
    return <></>;
  }
  return (
    <ErrorBoundary>
      <Row>
        <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
          <>
            <div>
              <PictureSourcSet
                img="warnungen_gemeinde_map_shh.png"
                path="https://www.dwd.de/DWD/warnungen/warnapp_gemeinden/json/"
                className="picture"
              />
            </div>
            {props.data.weather.warnungen.length > 0 ? (
              <div className="wetterwarnung">
                <h3>Wetterwarnung</h3>
                {props.data.weather.warnungen.map((item, idx) => (
                  <WeatherMessage key={idx} data={item} />
                ))}
              </div>
            ) : (
              <></>
            )}
            {props.data.weather.vorabinfo.length > 0 ? (
              <div className="unwettervorabinformation">
                <h3>Vorabinformation</h3>
                {props.data.weather.vorabinfo.map((item, idx) => (
                  <WeatherMessage key={idx} data={item} />
                ))}
              </div>
            ) : (
              <></>
            )}
            <div className="stand">
              Stand:
              {props.data.weather.time}
            </div>
            <div className="copyright">
              <a href="https://www.dwd.de" target="_blank" rel="noreferrer">
                <FAR className="copyright" />
                {props.data.weather.copy}
              </a>
            </div>
          </>
        </Col>
      </Row>
    </ErrorBoundary>
  );
};
export default UnwetterInfo;
