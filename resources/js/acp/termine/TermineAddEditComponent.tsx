import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Select from 'react-select';
import Input from '../../component/atoms/Form/Input/Input';
import InputDate from '../../component/atoms/Form/Input/InputDate';
import InputTime from '../../component/atoms/Form/Input/InputTime';
import Textarea from '../../component/atoms/Form/Textarea';
import ToggleSwitch from '../../component/atoms/Form/ToggleSwitch';
import PageHeadline from '../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../component/component_helper';
import GridSimple from '../../component/molecules/GridSimple';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../component/molecules/SaveInfoError';
import SaveLine from '../../component/molecules/SaveLine';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { TermineAddEditComponentProps } from '../../props/props';

const TermineAddEditComponent: React.FC<React.PropsWithChildren<TermineAddEditComponentProps>> = (
  props: TermineAddEditComponentProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [getSelectValues, setSelectValues] = useState<any>(null);
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getId, setId] = useState<number>(0);
  const [getTitle, setTitle] = useState<string>('');
  const [getDescription, setDescription] = useState<string>('');
  const [getPlaceId, setPlaceId] = useState<number>(0);
  const [getWearId, setWearId] = useState<number>(0);
  const [getStartDate, setStartDate] = useState<string>('');
  const [getEndDate, setEndDate] = useState<string>('');
  const [getTimeStart, setTimeStart] = useState<string>('');
  const [getTimeEnd, setTimeEnd] = useState<string>('');
  const [getSchedulerWearing, setSchedulerWearing] = useState<any>([]);
  const [getSchedulerPlaces, setSchedulerPlaces] = useState<any>([]);
  const [getActive, setActive] = useState(true);
  const [getMustBe, setMustBe] = useState(false);
  const [getIsPublic, setIsPublic] = useState(true);

  const { id } = useParams();

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function onChangePlace(e) {
    setPlaceId(e.value);
  }
  function onChangeWearing(e) {
    setWearId(e.value);
  }
  function setSelectedValue(id, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function setDefaultData(data) {
    setId(data.id);
    setTitle(data.title);
    setDescription(data.description);
    setPlaceId(data.place_id);
    setWearId(data.wear_id);
    setMustBe(data.must_be);
    setIsPublic(data.is_public);
    setActive(data.active);
    setStartDate(data.start_date);
    setTimeStart(data.start_time);
    setEndDate(data.end_date);
    setTimeEnd(data.end_time);
  }

  function makeDefaultSchedulerData(data) {
    setSchedulerWearing(data.wearing);
    setSchedulerPlaces(data.places);
  }

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    fetch('/api/admin/termine/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: getId,
        title: getTitle,
        description: getDescription,
        place_id: getPlaceId,
        wear_id: getWearId,
        datestart: getStartDate,
        dateend: getEndDate,
        timestart: getTimeStart,
        timeend: getTimeEnd,
        active: getActive,
        must_be: getMustBe,
        is_public: getIsPublic,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchPreData() {
      let data_response = await fetch('/api/admin/termine/predata');
      data_response = await data_response.json();
      setSelectValues(data_response);
      makeDefaultSchedulerData(data_response);
    }
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/termine/data/${id}`);
      response = await response.json();
      setLoading(false);
      setDefaultData(response);
    }
    fetchPreData();
    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading || getSelectValues === null) {
    return <LoadingAlertBox />;
  }
  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - Termin ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Titel:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getTitle}
                        name="title"
                        placeholder=""
                        className="form-control"
                        onChange={e => setTitle(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Beschreibung:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Textarea
                        defaultValue={getDescription}
                        name="tododescription"
                        placeholder=""
                        className="form-control"
                        onChange={e => setDescription(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Ort:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        value={setSelectedValue(getPlaceId, getSelectValues.places)}
                        options={getSelectValues.places}
                        className="basic-multi-select"
                        onChange={e => onChangePlace(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>

          <Row>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Begin Datum:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputDate
                        value={getStartDate}
                        name="datum"
                        placeholder=""
                        className="form-control"
                        onChange={e => setStartDate(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Begin Zeit:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputTime
                        value={getTimeStart}
                        name="time"
                        placeholder=""
                        className="form-control"
                        onChange={e => setTimeStart(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Ende Datum:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputDate
                        defaultValue={getEndDate}
                        name="datum"
                        placeholder=""
                        className="form-control"
                        onChange={e => setEndDate(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={3} xl={3} lg={3} md={3} sm={3} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Ende Zeit:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <InputTime
                        defaultValue={getTimeEnd}
                        name="time"
                        placeholder=""
                        className="form-control"
                        onChange={e => setTimeEnd(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Kleidung:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        value={setSelectedValue(getWearId, getSelectValues.wearing)}
                        options={getSelectValues.wearing}
                        className="basic-multi-select"
                        onChange={e => onChangeWearing(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>

          <Row>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Öffentlich?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        onChange={e => setIsPublic(!getIsPublic)}
                        value="1"
                        checked={getIsPublic}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Sichtbar?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getActive}
                        onChange={e => setActive(!getActive)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={4} sm={4} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Pflicht?:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <ToggleSwitch
                        checked={getMustBe}
                        onChange={e => setMustBe(!getMustBe)}
                        value="1"
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/admin/todo/overview" />
        </ErrorBoundary>
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
      </div>
    </div>
  );
};
export default TermineAddEditComponent;
